# Laravel 12 Upgrade Notes

This project has been upgraded from Laravel 5.7 to Laravel 12. This document outlines the changes made and steps needed to complete the upgrade.

## Changes Made

### 1. Composer Dependencies
- Updated PHP requirement from `^7.1.3` to `^8.2`
- Updated Laravel from `5.7.*` to `^12.0`
- Updated `barryvdh/laravel-dompdf` from `^0.8.5` to `^3.0`
- Updated `laravel/tinker` from `^1.0` to `^2.9`
- Removed deprecated packages:
  - `fideloper/proxy` (now built into Laravel)
  - `hesto/multi-auth` (no longer needed, kept admin guard configuration)
  - `beyondcode/laravel-dump-server` (no longer needed)
  - `filp/whoops` (built into Laravel)
  - `fzaninotto/faker` (replaced with `fakerphp/faker`)
- Added new packages:
  - `fakerphp/faker` for testing
  - `laravel/pint` for code formatting
- Updated autoload paths for seeders and factories
- Changed minimum-stability from "dev" to "stable"

### 2. Bootstrap Architecture (Laravel 12 New Structure)
- Updated `bootstrap/app.php` to use the new Laravel 12 configuration style
- Routes are now configured in bootstrap/app.php instead of RouteServiceProvider
- Removed `app/Providers/RouteServiceProvider.php` (no longer needed in Laravel 12)
- Middleware configuration now done in bootstrap/app.php

### 3. Kernel Changes
- Replaced `CheckForMaintenanceMode` with `PreventRequestsDuringMaintenance`
- Removed custom `CheckForMaintenanceMode` middleware
- Changed `$routeMiddleware` to `$middlewareAliases` (Laravel 11+ convention)
- Updated API middleware from string-based to class-based
- Added proper type hints to all properties
- Removed `bindings` from API middleware (replaced with `SubstituteBindings::class`)

### 4. Exception Handler
- Changed from `Exception` to `Throwable` type hints
- Updated to use new `register()` method pattern
- Removed deprecated `report()` and `render()` methods
- Added proper PHP 8.2+ type hints

### 5. Middleware Updates
- **TrustProxies**: Now extends Laravel's built-in class instead of fideloper/proxy
- **Authenticate**: Added return type hints and proper method signature
- **RedirectIfAuthenticated**: Updated to support multiple guards
- **TrimStrings**: Added `current_password` to except list
- **VerifyCsrfToken**: Removed deprecated `$addHttpCookie` property
- All middleware now have proper type annotations

### 6. Database Structure
- Moved `database/seeds/` to `database/seeders/`
- Updated `DatabaseSeeder` with proper namespace and type hints
- Updated `UserFactory` to use new class-based factory pattern
- Added proper `Database\Seeders` and `Database\Factories` namespaces

### 7. Models
- **User Model**: 
  - Added `HasFactory` trait
  - Changed `$casts` property to `casts()` method
  - Added `password => 'hashed'` cast
  - Updated all type hints
- **Admin Model**:
  - Added `HasFactory` trait
  - Added `casts()` method with proper date and boolean casts
  - Updated all type hints

### 8. Frontend/Assets
- Replaced Laravel Mix with Vite
- Updated `package.json`:
  - Removed webpack/laravel-mix dependencies
  - Added Vite and laravel-vite-plugin
  - Updated to latest versions of Bootstrap, Vue, jQuery
  - Replaced `postcss-rtl` with `postcss-rtlcss`
- Created `vite.config.js` for asset compilation
- Scripts now use `vite` and `vite build` instead of Mix commands

### 9. Testing
- Updated `phpunit.xml` to PHPUnit 11 format
- Changed to use coverage configuration format
- Updated environment variables for testing
- Added `APP_MAINTENANCE_DRIVER` configuration

### 10. Other Files
- Created `.gitignore` file with Laravel 12 standards
- Kept `app/Http/Kernel.php` for backward compatibility with custom middleware

## Required Steps to Complete Upgrade

### 1. Install Dependencies
```bash
# Make sure you have PHP 8.2 or higher installed
php --version

# Update Composer dependencies
composer update

# Install NPM dependencies
npm install

# Build assets
npm run build
```

### 2. Clear Caches
```bash
php artisan config:clear
php artisan cache:clear
php artisan route:clear
php artisan view:clear
```

### 3. Update Configuration Files
Review and update the following config files if needed:
- `config/app.php` - Check for any deprecated service providers
- `config/database.php` - Verify database connection settings
- `config/auth.php` - Ensure guards and providers are correct

### 4. Update Environment File
Ensure your `.env` file has:
```
APP_MAINTENANCE_DRIVER=file
```

### 5. Review Custom Code
- Check all controllers for deprecated methods
- Review any custom service providers
- Update any direct framework calls that may have changed
- Test all authentication flows (both web and admin guards)

### 6. Run Migrations
```bash
php artisan migrate
```

### 7. Test the Application
- Test all major functionality
- Check admin authentication
- Verify PDF generation still works
- Test all CRUD operations
- Verify file uploads and storage
- Test database backups

### 8. Update Third-Party Packages
The `wladmonax/laravel-db-backup` package may need attention:
- Check if it's compatible with Laravel 12
- Consider migrating to `spatie/laravel-backup` if issues arise

## Breaking Changes to Watch For

1. **Multi-Auth Package Removed**: The `hesto/multi-auth` package was removed. Admin authentication is now handled through Laravel's native multi-guard system. All routes and controllers using admin authentication have been preserved.

2. **Middleware Aliases**: Routes using middleware need to use the new aliases defined in `bootstrap/app.php`.

3. **Date Casting**: Models now use the `casts()` method instead of the `$casts` property.

4. **Factory Pattern**: If you create new factories, use the class-based pattern shown in `UserFactory.php`.

5. **Vite Instead of Mix**: All asset references in Blade templates need to use Vite's `@vite()` directive instead of Mix's `mix()` helper.

## Rollback Plan

If issues arise, you can:
1. Checkout the previous Git commit
2. Run `composer install` to restore old dependencies
3. Run `npm install` to restore old node modules

## Additional Resources

- [Laravel 12 Upgrade Guide](https://laravel.com/docs/12.x/upgrade)
- [Laravel 11 Upgrade Guide](https://laravel.com/docs/11.x/upgrade) (intermediate version)
- [Laravel 10 Upgrade Guide](https://laravel.com/docs/10.x/upgrade) (intermediate version)
