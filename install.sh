#!/usr/bin/env bash
# Run from INSIDE a fresh Laravel project (forms-lab-w8):
#   bash ../w8-overlay/install.sh
set -e
SRC="$(cd "$(dirname "$0")" && pwd)"
cp -R "$SRC/app" "$SRC/database" "$SRC/resources" "$SRC/routes" .
php artisan storage:link || true
php artisan migrate:fresh --seed
echo "Done. Run: php artisan serve  then open http://127.0.0.1:8000/courses"
