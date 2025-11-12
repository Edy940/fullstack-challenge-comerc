Write-Host "== Refresh database (migrate:fresh --seed) ==" -ForegroundColor Cyan
docker compose exec api-php bash -lc "cd /var/www/html && php artisan migrate:fresh --seed --force"
Write-Host "OK" -ForegroundColor Green