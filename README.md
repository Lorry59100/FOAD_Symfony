FOAD_Symfony README

# Create a .env.local file at root directory
add : 
- APP_ENV & APP_SECRET with the same values that in .env
- DATABASE_URL=your_database_config

# Run : 
- composer install
- composer require symfony/orm-pack
- composer require symfony/maker-bundle --dev
- composer require symfony/security-bundle
- composer require form validator
- php bin/console doctrine:database:create
- php bin/console make:migration
- php bin/console doctrine:migrations:migrate