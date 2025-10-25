#!/usr/bin/env node

import { execSync } from 'child_process';

/**
 * Generates the next dev version (0.0.x-dev)
 * Fetches latest dev version from npm registry and increments patch
 */

const PACKAGE_NAME = '@apidockit-com/sdk';
const REGISTRY = 'https://npm.pkg.github.com';
const TAG = 'dev';

try {
  // Try to get the latest dev version from npm registry
  const latestVersion = execSync(
    `npm view ${PACKAGE_NAME}@${TAG} version --registry=${REGISTRY}`,
    { encoding: 'utf-8', stdio: ['pipe', 'pipe', 'ignore'] }
  ).trim();

  if (latestVersion && latestVersion.includes('-dev')) {
    // Parse version (e.g., "0.0.5-dev") and increment patch
    const [versionPart] = latestVersion.split('-');
    const [major, minor, patch] = versionPart.split('.').map(Number);
    const newVersion = `${major}.${minor}.${patch + 1}-dev`;
    console.log(newVersion);
  } else {
    // No dev version found, start at 0.0.1-dev
    console.log('0.0.1-dev');
  }
} catch (error) {
  // Package not found or first dev publish, start at 0.0.1-dev
  console.log('0.0.1-dev');
}
