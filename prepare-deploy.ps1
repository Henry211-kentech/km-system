# Install Composer dependencies (no dev, optimized)
composer install --optimize-autoloader --no-dev

# Laravel optimizations
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Remove unnecessary files/folders (optional, adjust as needed)
Remove-Item -Recurse -Force node_modules, tests, .git, .github, .env.example, README.md, package.json, package-lock.json, yarn.lock -ErrorAction SilentlyContinue

# Create ZIP (excluding storage/logs and vendor/bin for smaller size)
$zipName = \"km-system-deploy.zip\"
if (Test-Path $zipName) { Remove-Item $zipName }
Compress-Archive -Path * -DestinationPath $zipName -CompressionLevel Optimal -Force -Exclude *.log,*.zip,storage\\logs\\*,vendor\\bin\\*

Write-Host \"Deployment ZIP created: $zipName\"