#!/bin/bash

# Ensure we're using the testing environment
echo "Preparing to run tests on the testing database..."

# Run migrations on the testing database
docker compose exec app php artisan migrate:fresh --database=pgsql_testing --env=testing --force

# Run tests with the testing environment
docker compose exec app php artisan test --env=testing

# Show results
echo "Tests completed."
