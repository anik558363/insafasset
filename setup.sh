#!/bin/bash
# LandMark Realty — Setup Script
# Run this after setting up your MySQL database

echo "==================================================="
echo "  LandMark Realty — Setup Script"
echo "==================================================="

# 1. Install composer dependencies (if not done)
if [ ! -d "vendor" ]; then
    echo "[1/5] Installing dependencies..."
    composer install --no-interaction
fi

# 2. Copy .env if it doesn't exist
if [ ! -f ".env" ]; then
    echo "[2/5] Copying .env file..."
    cp .env.example .env
    php artisan key:generate
fi

# 3. Run migrations
echo "[3/5] Running database migrations..."
php artisan migrate --force

# 4. Seed the database
echo "[4/5] Seeding database with sample data..."
php artisan db:seed --force

# 5. Storage link
echo "[5/5] Creating storage symlink..."
php artisan storage:link

# 6. Cache config
php artisan config:cache
php artisan route:cache

echo ""
echo "==================================================="
echo "  Setup complete!"
echo "  Admin URL: http://localhost:8000/admin"
echo "  Admin Email: admin@landmark.com"
echo "  Admin Password: password"
echo "==================================================="
echo ""
echo "Start the development server:"
echo "  php artisan serve"
