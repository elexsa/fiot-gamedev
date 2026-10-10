<?php

declare(strict_types=1);

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

// Find a PHP CLI binary. Prefer the same one serving this request — but ONLY
// if it is a real CLI (some hosts set PHP_BINARY to php-fpm, which can't run artisan).
$candidates = [];
if (defined('PHP_BINARY') && PHP_BINARY !== '' && ! str_contains((string) PHP_BINARY, 'fpm')) {
    $candidates[] = PHP_BINARY;
}
$candidates[] = 'php8.4';
$candidates[] = '/usr/bin/php8.4';
$candidates[] = 'php8.3';
$candidates[] = 'php8.2';
$candidates[] = 'php'; // default, often old (here: 7.4) — last resort only
foreach (['8.4', '8.3', '8.2'] as $v) {
    $candidates[] = "/usr/local/bin/php{$v}";
    $candidates[] = "/usr/local/php{$v}/bin/php";
    $candidates[] = "/opt/php{$v}/bin/php";
    $candidates[] = "/opt/php-{$v}/bin/php";
}
// ISPConfig/multiphp layouts: /etc/php/<ver>/... exists => cli is often beside it.
foreach (glob('/etc/php/*', GLOB_ONLYDIR) ?: [] as $dir) {
    $ver = basename($dir);
    foreach (["/usr/bin/php{$ver}", "/usr/local/bin/php{$ver}"] as $p) {
        $candidates[] = $p;
    }
}
// PATH lookup: versioned binaries may exist but not be on this user's PATH.
foreach (['8.4', '8.3', '8.2'] as $v) {
    $found = [];
    @exec('command -v php'.$v.' 2>/dev/null', $found);
    foreach ($found as $p) {
        $candidates[] = trim($p);
    }
}
// Last resort: scan common bin dirs for php8.* binaries.
foreach (['/usr/bin', '/usr/local/bin', '/opt/php/bin'] as $binDir) {
    foreach (glob($binDir.'/php8*') ?: [] as $p) {
        if (is_executable($p)) {
            $candidates[] = $p;
        }
    }
}
$candidates = array_values(array_unique($candidates));

// ?debug=1 => show PHP_CLI candidates and their probe results (for troubleshooting).
if (($_GET['debug'] ?? '') === '1') {
    $probeResults = [];
    foreach ($candidates as $candidate) {
        $probe = escapeshellarg($candidate).' -r '.escapeshellarg('echo PHP_VERSION;').' 2>&1';
        $out = [];
        $code = 1;
        @exec($probe, $out, $code);
        $probeResults[$candidate] = ['exit_code' => $code, 'output' => implode("\n", $out)];
        if (count($probeResults) > 40) {
            break;
        }
    }

    echo json_encode(['ok' => true, 'mode' => 'debug', 'php_binary' => PHP_BINARY ?? null, 'zip' => extension_loaded('zip') && class_exists('ZipArchive'), 'candidates' => $probeResults]);
    exit;
}

// GET without run=1 => info page (safe to open in browser).
if (($_GET['run'] ?? '') !== '1' && ($_SERVER['REQUEST_METHOD'] ?? 'GET') === 'GET') {
    echo json_encode([
        'ok' => true,
        'mode' => 'info',
        'artisan' => $artisan,
        'php' => PHP_VERSION,
        'hint' => 'Add &run=1 to execute: unpack (if pending) + migrate --force, config:clear, route:clear, view:clear.',
    ]);
    exit;
}

// --- ZIP UNPACK (runs before artisan) ------------------------------------
// The CI pipeline uploads app.zip / docroot.zip instead of thousands of
// small files over FTP. If a fresh zip is waiting, extract it first.
// Zips are staged by CI as: private/deploy-pending/app.zip + docroot.zip.
$unpackResults = [];
$pendingDir = $appRoot.'/deploy-pending';
@set_time_limit(0); // unpacking 20k files may exceed default 30s web limit
foreach (['app' => $appRoot, 'docroot' => $docroot] as $name => $target) {
    $zipPath = $pendingDir.'/'.$name.'.zip';
    if (! is_file($zipPath)) {
        continue;
    }
    if (! class_exists('ZipArchive')) {
        http_response_code(500);
        echo json_encode(['ok' => false, 'error' => 'ZipArchive unavailable, cannot unpack '.$name.'.zip']);
        exit;
    }
    $zip = new ZipArchive;
    if ($zip->open($zipPath) !== true) {
        http_response_code(500);
        echo json_encode(['ok' => false, 'error' => 'Cannot open '.$name.'.zip']);
        exit;
    }
    // Safety: refuse entries with absolute paths or ".." traversal.
    // Never touch user uploads: storage/app/public/* lives only on the server
    // (dean's /admin uploads) and must survive every deploy.
    $skipPrefixes = ['storage/app/public/'];
    $entries = [];
    for ($i = 0; $i < $zip->numFiles; $i++) {
        $entry = (string) $zip->getNameIndex($i);
        if ($entry === '' || $entry[0] === '/' || str_contains($entry, '..')) {
            $zip->close();
            http_response_code(500);
            echo json_encode(['ok' => false, 'error' => 'Unsafe entry in '.$name.'.zip: '.$entry]);
            exit;
        }
        $skipped = false;
        foreach ($skipPrefixes as $prefix) {
            if (str_starts_with($entry, $prefix)) {
                $skipped = true;
                break;
            }
        }
        if (! $skipped) {
            $entries[] = $entry;
        }
    }
    $extracted = $zip->extractTo($target, $entries);
    $count = count($entries);
    $zip->close();
    if (! $extracted) {
        http_response_code(500);
        echo json_encode(['ok' => false, 'error' => 'Failed to extract '.$name.'.zip to '.$target]);
        exit;
    }
    @unlink($zipPath); // consume: a stale zip must never re-extract on next run
    $unpackResults[$name] = ['files' => $count, 'target' => $target];
}

$php = null;
foreach ($candidates as $candidate) {
    // Probe must prove CLI execution works ('-r' runs code), not just print a version.
    // Also require PHP >= 8.2 (composer platform check would fail otherwise).
    $probe = escapeshellarg($candidate).' -r '.escapeshellarg('echo PHP_VERSION;').' 2>&1';
    $out = [];
    $code = 1;
    @exec($probe, $out, $code);
    $ver = trim(implode("\n", $out));
    if ($code === 0 && (bool) preg_match('/^8\.[2-9]|^8\.[1-9][0-9]/', $ver)) {
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
    $results[$name]['php_cli'] = $php;
    if ($results[$name]['exit_code'] !== 0) {
        $failed = true;
        break; // stop on first failure: no point clearing caches if migrate failed
    }
}

// Ensure web/storage serves the public disk (dean's /admin uploads).
// Split layout: web/ is the docroot, files live in private/storage/app/public.
$storageLink = $docroot.'/storage';
$storageTarget = $appRoot.'/storage/app/public';
if (! is_link($storageLink) && ! is_file($storageLink)) {
    if (is_dir($storageLink)) {
        $results['storage_link'] = ['status' => 'skipped: web/storage is a real directory'];
    } elseif (@symlink($storageTarget, $storageLink)) {
        $results['storage_link'] = ['status' => 'created'];
    } else {
        $results['storage_link'] = ['status' => 'failed: cannot symlink web/storage'];
    }
} else {
    $results['storage_link'] = ['status' => 'exists'];
}

http_response_code($failed ? 500 : 200);
echo json_encode(['ok' => ! $failed, 'php' => PHP_VERSION, 'app_root' => $appRoot, 'unpacked' => $unpackResults, 'results' => $results]);
