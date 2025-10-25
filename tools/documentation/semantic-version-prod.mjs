#!/usr/bin/env node

import { execSync } from 'child_process';

/**
 * Generates the next production version (0.0.x)
 * Fetches latest version from npm registry and increments patch
 */

const PACKAGE_NAME = '@apidockit-com/sdk';
const REGISTRY = 'https://npm.pkg.github.com';

try {
  // Try to get the latest published version from npm registry
  const latestVersion = execSync(
    `npm view ${PACKAGE_NAME} version --registry=${REGISTRY}`,
    { encoding: 'utf-8', stdio: ['pipe', 'pipe', 'ignore'] }
  ).trim();

  if (latestVersion) {
    // Parse version and increment patch
    const [major, minor, patch] = latestVersion.split('.').map(Number);
    const newVersion = `${major}.${minor}.${patch + 1}`;
    console.log(newVersion);
  } else {
    // No published version, start at 0.0.1
    console.log('0.0.1');
  }
} catch (error) {
  // Package not found or first publish, start at 0.0.1
  console.log('0.0.1');
}
