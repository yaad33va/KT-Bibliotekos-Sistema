# KT-Bibliotekos-Sistema
KT-Bibliotekos Sistema is a library management system built to simplify the organization of library collections, users, and transactions. 
The project is developed using PHP, Blade, CSS, and JavaScript for a reliable and user-friendly experience.
## Prerequisites
Ensure you have the following installed on your system:
- Docker
- PHP
- Composer

## Installation

Run the following commands to set up the project:

```bash
git clone https://github.com/yaad33va/KT-Bibliotekos-Sistema.git
cd KT-Bibliotekos-Sistema

# Install PHP dependencies
composer install

# Copy environment configuration
cp .env.example .env

# Start Docker containers using Sail
./vendor/bin/sail up -d

# Generate application key
./vendor/bin/sail artisan key:generate

# Run migrations and seed the database
./vendor/bin/sail artisan migrate:fresh --seed

# Install frontend dependencies
./vendor/bin/sail pnpm install

# Build frontend assets
./vendor/bin/sail npm run build
