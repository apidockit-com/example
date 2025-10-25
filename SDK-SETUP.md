# SDK Publishing & Consumption Guide

## Overview

This repository automatically generates and publishes a TypeScript SDK to GitHub Packages based on OpenAPI specifications generated from your Laravel application.

## Workflow Triggers

| Branch/Event | Workflow File | Version Format | npm Tag | When It Runs |
|--------------|---------------|----------------|---------|--------------|
| `main` push | `sdk-publish-prod.yml` | `0.0.x` | `latest` | Every push to main |
| `dev` push | `sdk-publish-dev.yml` | `0.0.x-dev` | `dev` | Every push to dev |
| Pull Request | `sdk-publish-pr.yml` | `0.0.x-pr-{number}` | `next` | On PR creation/update |

## Consuming the SDK

### 1. Create `.npmrc` in your project root

```
@api-doc-kit:registry=https://npm.pkg.github.com
//npm.pkg.github.com/:_authToken=${GITHUB_TOKEN}
always-auth=true
```

### 2. Set GITHUB_TOKEN environment variable

```bash
export GITHUB_TOKEN=your_github_personal_access_token
```

**Token Requirements:**
- Scope: `read:packages`
- Generate at: https://github.com/settings/tokens

### 3. Install the SDK

**Production (latest stable):**
```bash
npm install @api-doc-kit/sdk
```

**Development version:**
```bash
npm install @api-doc-kit/sdk@dev
```

**Specific PR version:**
```bash
npm install @api-doc-kit/sdk@0.0.5-pr-123
```

**Specific version:**
```bash
npm install @api-doc-kit/sdk@0.0.5
```

## Verification Checklist

### First-time Setup

- [ ] Verify GitHub organization `@api-doc-kit` exists
- [ ] Ensure repo has `packages: write` permission
- [ ] Check that `src/database/database.sqlite` is gitignored
- [ ] Confirm Laravel command `php artisan doc:generate` works locally

### After Pushing to `main`

- [ ] Go to Actions tab → "Publish SDK (Production)" workflow
- [ ] Check that workflow completed successfully
- [ ] Verify version was incremented (check workflow logs)
- [ ] Navigate to repository Packages tab
- [ ] Confirm new version is published with `latest` tag
- [ ] Test installation in consumer project

### After Pushing to `dev`

- [ ] Go to Actions tab → "Publish SDK (Dev)" workflow
- [ ] Check workflow succeeded
- [ ] Verify version includes `-dev` suffix
- [ ] Confirm package published with `dev` tag

### After Creating/Updating PR

- [ ] Go to Actions tab → "Publish SDK (Pull Request)" workflow
- [ ] Check workflow succeeded
- [ ] Look for automated comment on PR with install command
- [ ] Verify version includes `-pr-{number}` suffix
- [ ] Confirm package published with `next` tag

## Troubleshooting

### Issue: Workflow fails at "Install Composer dependencies"

**Symptoms:**
```
Your lock file does not contain a compatible set of packages
```

**Solution:**
```bash
cd src
composer update --lock
git add composer.lock
git commit -m "Update composer.lock"
git push
```

### Issue: Workflow fails at "Generate OpenAPI YAML and SDK"

**Symptoms:**
```
Error: Laravel could not boot / Database connection failed
```

**Solutions:**

1. Check that `database.sqlite` is created in workflow
2. Verify Laravel `.env.testing` or `.env.example` has proper SQLite config
3. Ensure migrations are not required for doc generation
4. If migrations are needed, add this step before "Generate OpenAPI":
   ```yaml
   - name: Run migrations
     run: cd src && php artisan migrate --force
   ```

### Issue: Workflow fails at "Publish SDK to GitHub Packages"

**Symptoms:**
```
npm ERR! 403 Forbidden - PUT https://npm.pkg.github.com/@api-doc-kit%2fsdk
```

**Solutions:**

1. Verify workflow has `packages: write` permission (check YAML)
2. Ensure package name in `openapi/sdk/package.json` matches `@api-doc-kit/sdk`
3. Check that `publishConfig.registry` is set to `https://npm.pkg.github.com`
4. Confirm repository belongs to `@api-doc-kit` organization

### Issue: Consumer cannot install SDK

**Symptoms:**
```
npm ERR! 404 Not Found - GET https://npm.pkg.github.com/@api-doc-kit%2fsdk
```

**Solutions:**

1. Verify `.npmrc` exists in consumer project root
2. Check `GITHUB_TOKEN` environment variable is set
3. Ensure token has `read:packages` scope
4. Confirm package was published (check repository Packages tab)
5. Try logging in manually:
   ```bash
   npm login --registry=https://npm.pkg.github.com --scope=@api-doc-kit
   ```

### Issue: SDK builds but TypeScript compilation fails

**Symptoms:**
```
error TS2307: Cannot find module 'X' or its corresponding type declarations
```

**Solutions:**

1. Check `openapi/sdk/tsconfig.json` has correct `compilerOptions`
2. Verify generated SDK source is valid TypeScript
3. Review OpenAPI spec for issues (run `npm run lint` in `tools/documentation`)
4. Ensure `@redocly/openapi-sdk-codegen` is up to date

### Issue: No version increment

**Symptoms:**
- Workflow succeeds but uses same version
- "No significant changes" message appears

**Cause:**
Only `package.json` changed (no actual SDK code changes)

**This is expected behavior** - the workflow skips publishing when only metadata changes to avoid unnecessary version bumps.

## Manual Workflow Trigger

You can manually trigger the production workflow:

1. Go to repository → Actions tab
2. Select "Publish SDK (Production)" workflow
3. Click "Run workflow" dropdown
4. Select branch (usually `main`)
5. Click "Run workflow" button

## Architecture

```
┌─────────────────┐
│   Laravel App   │
│     (src/)      │
└────────┬────────┘
         │
         │ php artisan doc:generate
         ▼
┌─────────────────┐
│  OpenAPI YAML   │
│  (storage/app)  │
└────────┬────────┘
         │
         │ npm run generate (tools/documentation)
         ▼
┌─────────────────┐
│  TypeScript SDK │
│  (openapi/sdk)  │
└────────┬────────┘
         │
         │ npm run build + npm publish
         ▼
┌─────────────────┐
│ GitHub Packages │
│ @api-doc-kit/sdk│
└─────────────────┘
```

## Version Management

Versions are automatically incremented by querying the npm registry for the latest published version and bumping the patch number.

**First publish:** `0.0.1`
**Second publish:** `0.0.2`
**Third publish:** `0.0.3`

Pre-release tags are appended for non-production environments:
- Dev: `0.0.5-dev`
- PR #42: `0.0.5-pr-42`

## CI/CD Best Practices

1. **Skip unnecessary publishes** - Workflows check for meaningful changes before publishing
2. **Parallel workflows** - Each environment has its own workflow to avoid conflicts
3. **No git commits** - Versions are set in-memory during build, not committed back
4. **Built-in authentication** - Uses `GITHUB_TOKEN`, no PAT required for publishing
5. **PR feedback** - Automated comments on PRs with install instructions
