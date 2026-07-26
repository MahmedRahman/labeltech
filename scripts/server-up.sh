#!/usr/bin/env bash
# Start / restart LabelTech on the production server (labeltech.site)
set -euo pipefail

cd "$(dirname "$0")/.."

echo "==> Ensuring Docker stack is up..."
docker compose up -d

echo "==> Waiting for containers..."
sleep 2
docker compose ps

echo "==> Clearing / rebuilding Laravel caches..."
docker compose exec -T app php artisan optimize:clear || true
docker compose exec -T app php artisan storage:link --force || true

if grep -q '^APP_ENV=production' .env 2>/dev/null; then
  docker compose exec -T app php artisan config:cache
  docker compose exec -T app php artisan route:cache
  docker compose exec -T app php artisan view:cache
fi

echo "==> Checking cloudflared tunnel..."
if systemctl is-active --quiet cloudflared; then
  echo "cloudflared is running"
else
  echo "WARNING: cloudflared is not running — starting it..."
  sudo systemctl start cloudflared || true
fi

echo "==> Health checks"
curl -fsS -o /dev/null -w "local :8000 -> HTTP %{http_code}\n" http://127.0.0.1:8000/ || true
curl -fsS -o /dev/null -w "https://labeltech.site -> HTTP %{http_code}\n" https://labeltech.site/ || true

echo "Done."
