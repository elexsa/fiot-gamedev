# Deploy automation — shared hosting over FTP (ISPConfig-style)

Goal: `git merge dev -> master` + `git push` = site updated, no manual FTP.

## How it works

```text
push to master
  └─> GitHub Actions (.github/workflows/deploy.yml)
        ├─ composer install --no-dev (PHP 8.4 + intl, same as prod)
        ├─ npm ci + npm run build      (fresh public/build + manifest)
        ├─ php artisan vendor:publish --tag=filament-assets
        ├─ pint --test (fail fast, no half-deploy)
        ├─ FTP upload app  -> <root>/private/   (everything except docroot)
        ├─ FTP upload mirror -> <root>/web/     (index.php, .htaccess, build/, images/, ...)
        └─ GET /deploy.php?token=...&run=1      (migrate --force + clear caches)
```

`deploy.php` is pure procedural PHP in the docroot — no Laravel middleware,
no session, no dependency on not-yet-migrated tables. Wrong token => 404.

## One-time setup (15 min)

### 1. Server layout — CONFIRM FIRST (do not skip!)

Open FTP and check: does the account root contain BOTH `web/` and `private/`?

- **Layout A (expected, ISPConfig):** root = `web853/` with `web/` (docroot)
  + `private/` (Laravel). The pipeline assumes this.
- **Layout B (single dir):** FTP lands directly in `web/` (docroot = Laravel
  `public/`). Then: upload app to `/` instead of `private/`, mirror `public/*`
  into `/` instead of `web/`, and put `deploy.php` into `/`.

If B (or anything else) — tell the agent and it will adjust `deploy.yml`
+ `deploy-hook.php` before you continue.

### 2. Upload the hook manually (once)

Copy `deploy/deploy-hook.php` -> `<root>/web/deploy.php` via FTP.
Edit `$EXPECTED_TOKEN` inside it (long random string, `openssl rand -hex 24`).

### 3. Server `.env` (manual, once — NEVER overwritten by deploys)

`<root>/private/.env` must exist with prod values:

```env
APP_ENV=production
APP_DEBUG=false
APP_URL=https://gamedev.kpi.ua
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=gamedevkpiua
DB_USERNAME=...
DB_PASSWORD=...
DEPLOY_HOOK_TOKEN=<same-as-hook-and-secret>
```

The pipeline never uploads `.env` (it's in the FTP exclude list).

### 4. GitHub Secrets (repo Settings -> Secrets and variables -> Actions)

| Secret | Example |
|--------|---------|
| `FTP_HOST` | `ftp.gamedev.kpi.ua` (or IP) |
| `FTP_USER` / `FTP_PASSWORD` | FTP account (write access to `web/` + `private/`) |
| `FTP_PRIVATE_DIR` | `private/` (if FTP root = web853/) or `/var/www/.../web853/private/` (if FTP root is above) |
| `FTP_WEB_DIR` | `web/` (same logic as above) |
| `APP_URL` | `https://gamedev.kpi.ua` |
| `DEPLOY_HOOK_TOKEN` | same as in hook + server `.env` |

### 5. First run

Merge `dev -> master`, push. Watch Actions tab. Expected: green, then
`{"ok": true}` from the hook step. Open the site + hard refresh.

## Safety notes

- `master` is the prod branch; `dev` stays canonical for work.
- `.env`, `database.sqlite`, logs, `storage/framework/*` cache are excluded
  from uploads — prod data is never clobbered.
- `public/hot` is excluded — dev HMR flag must never reach prod.
- Filament assets (`public/{css,fonts,js}/filament`) are gitignored, so the
  pipeline republishes them on every deploy.
- Migrations run with `--force` via the hook: idempotent, only pending
  migrations run (tracked in the `migrations` table). Seeds are NEVER run on prod.
- Filament `vendor:publish --tag=laravel-assets` on `composer update` is out of
  scope for deploys; the workflow publishes `filament-assets` explicitly.
