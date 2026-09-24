<?php

/**
 * ONE-TIME deploy hook for shared hosting without SSH (ISPConfig-style).
 *
 * Install (manual, once, via FTP/file manager):
 *   1. Copy this file to <FTP_ROOT>/web/deploy.php
 *      (next to web/index.php — it MUST live in the document root).
 *   2. Set $EXPECTED_TOKEN below OR define DEPLOY_HOOK_TOKEN env var
 *      (same value as the DEPLOY_HOOK_TOKEN GitHub Secret).
 *   3. Done — the CI pipeline calls:
 *        GET https://gamedev.kpi.ua/deploy.php?token=<TOKEN>&run=1
 *      which runs: migrate --force, config:clear, route:clear, view:clear.
 *
 * Security:
 *   - Wrong/missing token => 404 (indistinguishable from "no such page").
 *   - Works with ?token= in query OR Authorization: Bearer <token> header.
 *   - Runs OUTSIDE the Laravel "web" middleware group: pure procedural PHP,
 *     no session, no CSRF, no dependency on not-yet-migrated tables.
 *   - Kept permanently: `migrate --force` only runs pending migrations
 *     (already-run ones are skipped via the migrations table); seeds never run.
 */

// ---------------------------------------------------------------------------
// !!! SET THIS to the same value as the DEPLOY_HOOK_TOKEN GitHub Secret !!!
// Prefer env var on the server if your panel allows it; fallback is below.
// ---------------------------------------------------------------------------
$EXPECTED_TOKEN = getenv('DEPLOY_HOOK_TOKEN') ?: 'CHANGE-ME-TO-A-LONG-RANDOM-STRING';

// ---------------------------------------------------------------------------
declare(strict_types=1);

header('X-Content-Type-Options: nosniff');

$provided = (string) ($_GET['token'] ?? '');
if ($provided === '' && isset($_SERVER['HTTP_AUTHORIZATION'])) {
    if (preg_match('/Bearer\s+(.+)/i', (string) $_SERVER['HTTP_AUTHORIZATION'], $m)) {
        $provided = trim($m[1]);
    }
}

if ($EXPECTED_TOKEN === '' || $EXPECTED_TOKEN === 'CHANGE-ME-TO-A-LONG-RANDOM-STRING' || ! hash_equals($EXPECTED_TOKEN, $provided)) {
    http_response_code(404);
    header('Content-Type: application/json');
    echo json_encode(['ok' => false, 'error' => 'Not found.']);
    exit;
}

// Resolve Laravel root: deploy.php lives in web/ (docroot), app lives in ../private/.
$docroot = __DIR__;
$appRoot = realpath($docroot.'/../private') ?: ($docroot.'/../private');
$artisan = $appRoot.'/artisan';

if (! is_file($artisan)) {
    // Fallback: maybe the host maps web/ == public/ directly (single-dir layout).
    $appRoot = realpath($docroot.'/..') ?: ($docroot.'/..');
    $artisan = $appRoot.'/artisan';
}

header('Content-Type: application/json');

if (! is_file($artisan)) {
    http_response_code(500);
    echo json_encode(['ok' => false, 'error' => "artisan not found. Looked in: {$artisan}. Fix layout (see deploy/README.md)."]);
    exit;
}

// GET without run=1 => info page (safe to open in browser).
if (($_GET['run'] ?? '') !== '1' && ($_SERVER['REQUEST_METHOD'] ?? 'GET') === 'GET') {
    echo json_encode([
        'ok' => true,
        'mode' => 'info',
        'artisan' => $artisan,
        'php' => PHP_VERSION,
        'hint' => 'Add &run=1 to execute: migrate --force, config:clear, route:clear, view:clear.',
    ]);
    exit;
}

// Find a PHP binary. Prefer the same one serving this request.
$candidates = [];
if (defined('PHP_BINARY') && PHP_BINARY !== '') {
    $candidates[] = PHP_BINARY;
}
$candidates[] = 'php';
foreach (['8.4', '8.3', '8.2'] as $v) {
    $candidates[] = "php{$v}";
    $candidates[] = "/usr/bin/php{$v}";
    $candidates[] = "/usr/local/bin/php{$v}";
}

$php = null;
foreach ($candidates as $candidate) {
    $probe = escapeshellarg($candidate).' -v 2>&1';
    $out = [];
    $code = 1;
    @exec($probe, $out, $code);
    if ($code === 0 && str_contains(implode("\n", $out), 'PHP')) {
        $php = $candidate;
        break;
    }
}

if ($php === null) {
    http_response_code(500);
    echo json_encode(['ok' => false, 'error' => 'No PHP CLI binary found on the server.']);
    exit;
}

$run = static function (string $command) use ($php, $appRoot): array {
    // --no-ansi: plain output safe for JSON; 300s cap per command.
    $cmd = 'cd '.escapeshellarg($appRoot).' && '.escapeshellarg($php).' artisan '.$command.' --no-ansi 2>&1';
    $out = [];
    $code = 0;
    @exec($cmd, $out, $code);

    return ['exit_code' => $code, 'output' => implode("\n", $out)];
};

$steps = [
    'migrate' => 'migrate --force',
    'config:clear' => 'config:clear',
    'route:clear' => 'route:clear',
    'view:clear' => 'view:clear',
];

$results = [];
$failed = false;
foreach ($steps as $name => $command) {
    $results[$name] = $run($command);
    if ($results[$name]['exit_code'] !== 0) {
        $failed = true;
        break; // stop on first failure: no point clearing caches if migrate failed
    }
}

http_response_code($failed ? 500 : 200);
echo json_encode(['ok' => ! $failed, 'php' => PHP_VERSION, 'app_root' => $appRoot, 'results' => $results]);
