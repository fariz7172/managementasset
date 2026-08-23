#!/bin/bash

# Target directory
TARGET_DIR="/home/u674511048/domains/farizahmad.com/public_html/sidaju"

echo "Memulai proses deployment SIDAJU..."

# 1. Bersihkan & Clone Repository
mkdir -p "$TARGET_DIR"
cd "$TARGET_DIR"

if [ -d .git ]; then
    echo "Repositori sudah ada. Menarik pembaruan terbaru..."
    git fetch --all
    git reset --hard origin/farizahmad.github.io
else
    echo "Kloning repositori baru..."
    rm -rf *
    git clone https://github.com/fariz7172/simsudin.git .
    git checkout farizahmad.github.io
fi

# 2. Setup .env Production
echo "Menyiapkan konfigurasi .env..."
cp .env.example .env
sed -i 's/DB_DATABASE=laravel/DB_DATABASE=u674511048_simsudin/g' .env
sed -i 's/DB_USERNAME=root/DB_USERNAME=u674511048_simsudin/g' .env
sed -i 's/DB_PASSWORD=/DB_PASSWORD=!FarizAhmad123456/g' .env
sed -i 's/APP_ENV=local/APP_ENV=production/g' .env
sed -i 's/APP_DEBUG=true/APP_DEBUG=false/g' .env
sed -i 's/APP_URL=http:\/\/localhost/APP_URL=https:\/\/simsudin.farizahmad.com/g' .env

# 3. Install Dependencies
echo "Menginstal dependensi Composer..."
composer install --no-dev --optimize-autoloader

# 4. Generate Key & Link Storage
echo "Menyiapkan framework Laravel..."
php artisan key:generate
php artisan storage:link

# 5. Jalankan Migrasi Database
echo "Menjalankan migrasi database..."
php artisan migrate --force

# 6. Setup htaccess untuk redirect ke public
echo "Membuat konfigurasi .htaccess..."
cat << 'EOF' > .htaccess
<IfModule mod_rewrite.c>
    RewriteEngine On
    RewriteRule ^(.*)$ public/$1 [L]
</IfModule>
EOF

echo "Deployment SIMSUDIN Selesai! 🎉"
