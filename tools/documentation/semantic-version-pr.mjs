#!/usr/bin/env node

import { execSync } from 'child_process';

/**
 * Generates the next PR version (0.0.x-pr-{number})
 * Fetches latest version from npm registry and increments patch
 * Appends PR number from GITHUB_PR_NUMBER environment variable
 */

const PACKAGE_NAME = '@api-doc-kit/sdk';
const REGISTRY = 'https://npm.pkg.github.com';
const PR_NUMBER = process.env.GITHUB_PR_NUMBER || '0';

try {
  // Try to get the latest published version from npm registry
  const latestVersion = execSync(
    `npm view ${PACKAGE_NAME} version --registry=${REGISTRY}`,
    { encoding: 'utf-8', stdio: ['pipe', 'pipe', 'ignore'] }
  ).trim();

  if (latestVersion) {
    // Parse version and increment patch
    const versionPart = latestVersion.split('-')[0]; // Remove any pre-release tags
    const [major, minor, patch] = versionPart.split('.').map(Number);
    const newVersion = `${major}.${minor}.${patch + 1}-pr-${PR_NUMBER}`;
    console.log(newVersion);
  } else {
    // No published version, start at 0.0.1-pr-{number}
    console.log(`0.0.1-pr-${PR_NUMBER}`);
  }
} catch (error) {
  // Package not found or first publish, start at 0.0.1-pr-{number}
  console.log(`0.0.1-pr-${PR_NUMBER}`);
}
