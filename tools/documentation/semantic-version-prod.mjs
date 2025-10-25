#!/usr/bin/env node

import { execSync } from 'child_process';
import { writeFileSync, unlinkSync } from 'fs';
import { tmpdir } from 'os';
import { join } from 'path';

/**
 * Generates the next production version (0.0.x)
 * Fetches latest version from npm registry and increments patch
 */

const PACKAGE_NAME = '@apidockit-com/sdk';
const REGISTRY = 'https://npm.pkg.github.com';
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

  // Try to get the latest published version from npm registry
  const command = `npm view ${PACKAGE_NAME} version --registry=${REGISTRY}${npmrcCreated ? ` --userconfig=${tmpNpmrc}` : ''}`;
  const latestVersion = execSync(command, {
    encoding: 'utf-8',
    stdio: ['pipe', 'pipe', 'pipe']
  }).trim();

  if (latestVersion) {
    // Parse version and increment patch
    const [major, minor, patch] = latestVersion.split('.').map(Number);
    const newVersion = `${major}.${minor}.${patch + 1}`;
    process.stderr.write(`📦 Latest version: ${latestVersion} → New version: ${newVersion}\n`);
    console.log(newVersion);
  } else {
    // No published version, start at 0.0.1
    process.stderr.write('📦 No previous version found, starting at 0.0.1\n');
    console.log('0.0.1');
  }
} catch (error) {
  // Package not found or first publish, start at 0.0.1
  process.stderr.write(`📦 Package not found (first publish), starting at 0.0.1\n`);
  console.log('0.0.1');
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
