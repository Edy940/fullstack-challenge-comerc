param([switch]$Rebuild)

Write-Host "== Subindo containers ==" -ForegroundColor Cyan
if ($Rebuild) {
  docker compose up -d --build
} else {
  docker compose up -d
}

Write-Host "== Gerando APP_KEY ==" -ForegroundColor Cyan
docker compose exec api-php bash -lc "cd /var/www/html && php artisan key:generate || true"

Write-Host "== Migrations & Seeds ==" -ForegroundColor Cyan
docker compose exec api-php bash -lc "cd /var/www/html && php artisan migrate:fresh --seed --force"

Write-Host "== Pronto! ==" -ForegroundColor Green
Write-Host "API:      http://localhost:8080"
Write-Host "Frontend: http://localhost:5173"
Write-Host "Mailhog:  http://localhost:8025"