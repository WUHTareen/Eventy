#!/bin/bash
# Eventy deploy script — server par changes laane ke liye
# Usage: bash deploy.sh
cd "$(dirname "$0")" || exit 1

echo "==> Pulling latest from GitHub..."
git pull origin main || { echo "!! git pull failed"; exit 1; }

echo "==> Running migrations..."
php artisan migrate --force || echo "!! migrate had issues (continuing anyway)"

echo "==> Ensuring storage symlink..."
php artisan storage:link 2>/dev/null || echo "   (storage link already exists)"

echo "==> Clearing caches..."
php artisan view:clear
php artisan route:clear
php artisan config:clear

echo "==> Done. Deploy complete."
