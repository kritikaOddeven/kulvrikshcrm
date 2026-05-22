#!/bin/bash

echo "Starting Laravel Deployment Script..."

# Step 1: Ask questions first
read -p "Do you want to delete all tables? (yes/no): " wipe_response
if [[ "$wipe_response" != "yes" ]]; then
    read -p "Do you want to run migrations? (yes/no): " migrate_response
fi
read -p "Do you want to run seeders? (yes/no): " seed_response

read -p "Do you want to run it on local? (yes/no): " is_local

# Step 2: Database operations based on user input
if [[ "$wipe_response" == "yes" ]]; then
    echo "Wiping the database and running migrations..."
    php artisan db:wipe
    php artisan migrate
else
    echo "Skipping database wipe..."
    if [[ "$migrate_response" == "yes" ]]; then
        echo "Running migrations..."
        php artisan migrate
    else
        echo "Skipping migrations..."
    fi
fi

# Step 3: Run seeders if requested
if [[ "$seed_response" == "yes" ]]; then
    echo "Running seeders..."
    php artisan db:seed
else
    echo "Skipping seeders..."
fi

if [[ "$is_local" == "yes" ]]; then
    # Step 4: Run Composer Install
    echo "Running composer install..."
    composer install

    # Step 5: Run Composer Dump-Autoload
    echo "Running composer dump-autoload..."
    composer dump-autoload
else
    # Step 4: Run Composer Install
    echo "Running composer install..."
    composer2 install

    # Step 5: Run Composer Dump-Autoload
    echo "Running composer dump-autoload..."
    composer2 dump-autoload
fi

echo "Laravel deployment completed successfully!"
