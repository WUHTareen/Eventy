#!/bin/bash
# Eventy deploy script — server par changes laane ke liye
# Usage: bash deploy.sh
set -e
cd "$(dirname "$0")"
echo "==> Pulling latest from GitHub..."
git pull origin main
echo "==> Running migrations..."
php artisan migrate --force
echo "==> Clearing caches..."
php artisan view:clear
php artisan route:clear
php artisan config:clear
echo "==> Done. Deploy complete."
