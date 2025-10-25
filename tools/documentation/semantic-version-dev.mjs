#!/usr/bin/env node

import { execSync } from 'child_process';
import { writeFileSync, unlinkSync } from 'fs';
import { tmpdir } from 'os';
import { join } from 'path';

/**
 * Generates the next dev version (0.0.x-dev)
 * Fetches latest dev version from npm registry and increments patch
 */

const PACKAGE_NAME = '@apidockit-com/sdk';
const REGISTRY = 'https://npm.pkg.github.com';
const TAG = 'dev';
const AUTH_TOKEN = process.env.NODE_AUTH_TOKEN;

// Create temporary .npmrc with authentication
const tmpNpmrc = join(tmpdir(), `.npmrc-${Date.now()}`);
let npmrcCreated = false;

try {
  if (AUTH_TOKEN) {
    const npmrcContent = `@apidockit-com:registry=https://npm.pkg.github.com
//npm.pkg.github.com/:_authToken=${AUTH_TOKEN}
always-auth=true`;
    writeFileSync(tmpNpmrc, npmrcContent);
    npmrcCreated = true;
    process.stderr.write('✅ Authentication configured for npm view\n');
  }

  // Try to get the latest dev version from npm registry
  const command = `npm view ${PACKAGE_NAME}@${TAG} version --registry=${REGISTRY}${npmrcCreated ? ` --userconfig=${tmpNpmrc}` : ''}`;
  const latestVersion = execSync(command, {
    encoding: 'utf-8',
    stdio: ['pipe', 'pipe', 'pipe']
  }).trim();

  if (latestVersion && latestVersion.includes('-dev')) {
    // Parse version (e.g., "0.0.5-dev") and increment patch
    const [versionPart] = latestVersion.split('-');
    const [major, minor, patch] = versionPart.split('.').map(Number);
    const newVersion = `${major}.${minor}.${patch + 1}-dev`;
    process.stderr.write(`📦 Latest dev version: ${latestVersion} → New version: ${newVersion}\n`);
    console.log(newVersion);
  } else {
    // No dev version found, start at 0.0.1-dev
    process.stderr.write('📦 No previous dev version found, starting at 0.0.1-dev\n');
    console.log('0.0.1-dev');
  }
} catch (error) {
  // Package not found or first dev publish, start at 0.0.1-dev
  process.stderr.write(`📦 Package not found (first dev publish), starting at 0.0.1-dev\n`);
  console.log('0.0.1-dev');
} finally {
  // Clean up temporary .npmrc
  if (npmrcCreated) {
    try {
      unlinkSync(tmpNpmrc);
    } catch (e) {
      // Ignore cleanup errors
    }
  }
}
