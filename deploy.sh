#!/bin/bash
# Eventy deploy script — server par changes laane ke liye
# Usage: bash deploy.sh
cd "$(dirname "$0")" || exit 1

echo "==> Pulling latest from GitHub..."
git pull origin main || { echo "!! git pull failed"; exit 1; }

echo "==> Running migrations..."
php artisan migrate --force || echo "!! migrate had issues (continuing anyway)"

echo "==> Ensuring storage symlink..."
if [ -L public/storage ] || [ -e public/storage ]; then
    echo "   (storage link already exists)"
else
    php artisan storage:link
fi

echo "==> Clearing caches..."
php artisan view:clear
php artisan route:clear
php artisan config:clear

echo "==> Done. Deploy complete."
