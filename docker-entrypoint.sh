#!/bin/bash
set -e

# Colors for output
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
BLUE='\033[0;34m'
NC='\033[0m' # No Color

# Function to print colored messages
print_info() {
    echo -e "${BLUE}ℹ️  $1${NC}"
}

print_success() {
    echo -e "${GREEN}✓ $1${NC}"
}

print_warning() {
    echo -e "${YELLOW}⚠️  $1${NC}"
}

print_error() {
    echo -e "${RED}❌ $1${NC}"
}

echo "=========================================="
echo "Starting Laravel Application Entrypoint"
echo "=========================================="

# Change to working directory
cd /var/www/html || {
    print_error "Failed to change to /var/www/html directory"
    exit 1
}

# Check if composer.json exists
if [ ! -f "composer.json" ]; then
    print_error "composer.json not found!"
    exit 1
fi
print_success "composer.json found"

# Check if composer is available
if ! command -v composer &> /dev/null; then
    print_error "Composer not found!"
    exit 1
fi
print_success "Composer is available"

# Check PHP version and extensions
print_info "Checking PHP environment..."
php -v | head -n 1
php -m | grep -q pdo_sqlite && print_success "PDO SQLite extension is loaded" || print_warning "PDO SQLite extension not found"

# Install Composer dependencies if vendor directory doesn't exist or is empty
if [ ! -d "vendor" ] || [ -z "$(ls -A vendor 2>/dev/null)" ]; then
    print_info "Installing Composer dependencies..."
    if composer install --no-interaction --optimize-autoloader; then
        print_success "Composer dependencies installed successfully"
    else
        print_error "Failed to install Composer dependencies"
        exit 1
    fi
else
    print_success "Vendor directory exists, skipping composer install"
fi

# Verify vendor/autoload.php exists
if [ ! -f "vendor/autoload.php" ]; then
    print_warning "vendor/autoload.php not found. Running composer dump-autoload..."
    composer dump-autoload --optimize --no-interaction || {
        print_error "Failed to dump autoload"
        exit 1
    }
fi
print_success "Autoload file verified"

# Check if .env file exists, if not create from .env.example
if [ ! -f ".env" ]; then
    if [ -f ".env.example" ]; then
        print_info "Creating .env file from .env.example..."
        cp .env.example .env
        print_success ".env file created"
    else
        print_warning ".env file not found and .env.example doesn't exist"
    fi
else
    print_success ".env file exists"
fi

# Generate application key if not set
if [ -f ".env" ]; then
    if ! grep -q "APP_KEY=base64:" .env 2>/dev/null; then
        print_info "Generating application key..."
        php artisan key:generate --force --no-interaction 2>/dev/null && print_success "Application key generated" || print_warning "Failed to generate application key"
    else
        print_success "Application key already exists"
    fi
fi

# Set proper permissions
print_info "Setting permissions..."
chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache 2>/dev/null || true
chmod -R 755 /var/www/html/storage /var/www/html/bootstrap/cache 2>/dev/null || true
print_success "Permissions set for storage and cache directories"

# Ensure database directory exists
if [ ! -d "/var/www/html/database" ]; then
    mkdir -p /var/www/html/database
    print_success "Database directory created"
fi

# Ensure SQLite database file exists and has proper permissions
if [ -f "/var/www/html/database/database.sqlite" ]; then
    chown www-data:www-data /var/www/html/database/database.sqlite 2>/dev/null || true
    chmod 664 /var/www/html/database/database.sqlite 2>/dev/null || true
    print_success "SQLite database permissions set"
else
    print_info "Creating SQLite database file..."
    touch /var/www/html/database/database.sqlite 2>/dev/null || {
        print_error "Failed to create SQLite database file"
        exit 1
    }
    chown www-data:www-data /var/www/html/database/database.sqlite 2>/dev/null || true
    chmod 664 /var/www/html/database/database.sqlite 2>/dev/null || true
    print_success "SQLite database file created"
fi

# Check if Node.js and npm are available
if command -v node &> /dev/null && command -v npm &> /dev/null; then
    print_success "Node.js and npm are available"
    
    # Check if package.json exists
    if [ -f "package.json" ]; then
        # Check if node_modules exists or if package.json changed
        if [ ! -d "node_modules" ] || [ "package.json" -nt "node_modules" ]; then
            print_info "Installing npm dependencies..."
            npm install --no-audit --no-fund 2>/dev/null && print_success "npm dependencies installed" || print_warning "Failed to install npm dependencies"
        else
            print_success "npm dependencies already installed"
        fi
        
        # Check if Vite manifest exists
        if [ ! -f "public/build/manifest.json" ]; then
            print_info "Building Vite assets..."
            npm run build 2>/dev/null && print_success "Vite assets built successfully" || print_warning "Failed to build Vite assets"
        else
            print_success "Vite manifest already exists"
        fi
    else
        print_warning "package.json not found, skipping npm steps"
    fi
else
    print_warning "Node.js or npm not found, skipping asset building"
fi

# Clear Laravel caches
print_info "Clearing Laravel caches..."
php artisan config:clear 2>/dev/null && print_success "Config cache cleared" || print_warning "Failed to clear config cache"
php artisan cache:clear 2>/dev/null && print_success "Application cache cleared" || print_warning "Failed to clear application cache"
php artisan route:clear 2>/dev/null && print_success "Route cache cleared" || print_warning "Failed to clear route cache"
php artisan view:clear 2>/dev/null && print_success "View cache cleared" || print_warning "Failed to clear view cache"

# Final verification
if [ ! -f "vendor/autoload.php" ]; then
    print_error "vendor/autoload.php still not found after all attempts!"
    ls -la vendor/ 2>/dev/null || echo "Vendor directory does not exist"
    exit 1
fi

# Check if Laravel is properly installed
if ! php artisan --version &>/dev/null; then
    print_warning "Laravel artisan command may not be working properly"
fi

echo "=========================================="
print_success "All checks passed!"
echo "=========================================="
print_info "Starting Laravel development server on 0.0.0.0:8000..."
print_info "Logs will be visible in Docker logs."
print_info "To view logs, run: docker-compose logs -f app"
print_info "Or: docker logs -f labeltech_app"
echo "=========================================="

# Ensure Laravel logs go to stderr for Docker visibility
export LOG_CHANNEL=${LOG_CHANNEL:-stderr}
export LOG_LEVEL=${LOG_LEVEL:-debug}

# Start Laravel's built-in server
# The server will output all requests and errors to stdout/stderr
# Using exec to replace shell process and ensure logs are visible
exec php artisan serve --host=0.0.0.0 --port=8000

