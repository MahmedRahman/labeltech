#!/bin/bash
set -e

echo "Starting entrypoint script..."

# Change to working directory
cd /var/www/html

# Check if composer.json exists
if [ ! -f "composer.json" ]; then
    echo "ERROR: composer.json not found!"
    exit 1
fi

# Check if composer is available
if ! command -v composer &> /dev/null; then
    echo "ERROR: Composer not found!"
    exit 1
fi

# Install Composer dependencies if vendor directory doesn't exist or is empty
if [ ! -d "vendor" ] || [ -z "$(ls -A vendor 2>/dev/null)" ]; then
    echo "Vendor directory missing or empty. Installing Composer dependencies..."
    composer install --no-interaction --optimize-autoloader
    echo "Composer dependencies installed successfully."
else
    echo "Vendor directory exists. Skipping composer install."
fi

# Verify vendor/autoload.php exists
if [ ! -f "vendor/autoload.php" ]; then
    echo "WARNING: vendor/autoload.php not found after installation. Running composer dump-autoload..."
    composer dump-autoload --optimize --no-interaction
fi

# Set proper permissions
echo "Setting permissions..."
chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache 2>/dev/null || true
chmod -R 755 /var/www/html/storage /var/www/html/bootstrap/cache 2>/dev/null || true

# Verify vendor/autoload.php exists before starting
if [ ! -f "vendor/autoload.php" ]; then
    echo "ERROR: vendor/autoload.php still not found!"
    ls -la vendor/ 2>/dev/null || echo "Vendor directory does not exist"
    exit 1
fi

echo "Starting php-fpm..."
# Start php-fpm (php-fpm will handle user switching internally)
exec php-fpm

