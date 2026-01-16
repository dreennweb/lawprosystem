# Post-Upgrade Checklist for Laravel 12

## Critical Steps (Must Complete)

### 1. Install Dependencies
- [ ] Run `composer install` or `composer update` with PHP 8.2+
- [ ] Run `npm install`
- [ ] Run `npm run build` to compile assets with Vite

### 2. Update Blade Templates for Vite
All Blade templates that reference assets need to be updated:

**Old Laravel Mix syntax:**
```blade
<link href="{{ mix('css/app.css') }}" rel="stylesheet">
<script src="{{ mix('js/app.js') }}"></script>
```

**New Vite syntax:**
```blade
@vite(['resources/sass/app.scss', 'resources/js/app.js'])
```

Search and replace in all `.blade.php` files in `resources/views/`

### 3. Database Setup
- [ ] Run `php artisan migrate:status` to check migrations
- [ ] Run `php artisan migrate` if needed
- [ ] Test database connections

### 4. Clear All Caches
```bash
php artisan config:clear
php artisan cache:clear
php artisan route:clear
php artisan view:clear
php artisan optimize:clear
```

### 5. Storage Link
- [ ] Run `php artisan storage:link` if not already linked

## Testing Checklist

### Authentication
- [ ] Test user login (web guard)
- [ ] Test admin login (admin guard)
- [ ] Test logout functionality
- [ ] Test password reset flows
- [ ] Test registration if applicable
- [ ] Verify middleware protection on routes

### Admin Panel Features
- [ ] Dashboard analytics/KPIs
- [ ] Case management (create, edit, delete, view)
- [ ] Case running/history
- [ ] Case priority and transfer workflows
- [ ] Client management
- [ ] Client onboarding
- [ ] Appointments (create, calendar view, notifications)
- [ ] Tasks management
- [ ] Invoice generation
- [ ] Payment history
- [ ] Expense tracking
- [ ] Vendor management
- [ ] Service configuration
- [ ] RBAC/Permissions (role assignment, permission matrices)
- [ ] Profile management
- [ ] SMTP settings configuration
- [ ] General settings
- [ ] Database backup functionality (`/backup` route)

### PDF Generation
- [ ] Test PDF exports (invoices, reports, etc.)
- [ ] Verify dompdf compatibility with Laravel 12
- [ ] Check PDF formatting and styling

### File Operations
- [ ] Test file uploads
- [ ] Test file downloads
- [ ] Verify storage paths
- [ ] Test image uploads (profile images, etc.)

### Localization
- [ ] Switch language to English
- [ ] Switch language to Arabic
- [ ] Verify RTL layout in Arabic
- [ ] Test all translated strings

### Database Operations
- [ ] Test SELECT queries
- [ ] Test INSERT operations
- [ ] Test UPDATE operations
- [ ] Test DELETE operations
- [ ] Test relationships (belongsTo, hasMany, etc.)
- [ ] Verify database backup route works

### API Endpoints (if used)
- [ ] Test all API routes
- [ ] Verify API authentication
- [ ] Check throttling works correctly

### Utility Routes
- [ ] `/backup` - Database backup
- [ ] `/createlink` - Storage link
- [ ] `/clear-cache` - Cache clearing
- [ ] Any other utility routes

## Known Issues to Watch For

### 1. Multi-Auth Package Removed
The `hesto/multi-auth` package was removed. Admin authentication now uses Laravel's native multi-guard system. Verify:
- Admin routes still protected
- Admin middleware working
- Admin dashboard accessible
- Admin-specific features functional

### 2. Database Backup Package
The `wladmonax/laravel-db-backup` package may need attention:
- Test backup functionality thoroughly
- Check compatibility with Laravel 12
- Consider migrating to `spatie/laravel-backup` if issues persist

### 3. Model Casts
All models now use `casts()` method instead of `$casts` property:
- Check all models in `app/Model/` directory
- Verify date fields are being cast correctly
- Test boolean fields
- Ensure password hashing works

### 4. Blade Directives
Some Blade directives may have changed:
- `@auth` and `@guest` work the same
- Verify custom directives if any
- Test `@can` directives for permissions

## Performance Verification

- [ ] Check page load times
- [ ] Verify asset compilation is working
- [ ] Test with browser dev tools for console errors
- [ ] Check database query performance
- [ ] Verify caching is working properly

## Security Checks

- [ ] CSRF protection working on forms
- [ ] XSS middleware functioning
- [ ] SQL injection protection (use parameterized queries)
- [ ] File upload validation
- [ ] Authentication redirects working
- [ ] Authorization checks on all protected routes

## Browser Compatibility

Test on:
- [ ] Chrome/Edge (latest)
- [ ] Firefox (latest)
- [ ] Safari (latest)
- [ ] Mobile browsers (iOS Safari, Chrome Mobile)

## Deployment Considerations

Before deploying to production:
1. Run `npm run build` for production assets
2. Set `APP_DEBUG=false` in `.env`
3. Set `APP_ENV=production` in `.env`
4. Run `php artisan config:cache`
5. Run `php artisan route:cache`
6. Run `php artisan view:cache`
7. Ensure proper file permissions on storage and cache directories
8. Verify .env file has all required variables
9. Test backup and restore procedures
10. Document any custom configurations

## Rollback Plan

If critical issues are discovered:
1. Keep a backup of the previous working version
2. Document the specific issue
3. Restore from backup if necessary
4. Fix the issue and re-test before deploying again

## Support Resources

- Laravel 12 Documentation: https://laravel.com/docs/12.x
- Laravel Upgrade Guide: https://laravel.com/docs/12.x/upgrade
- Vite Documentation: https://vitejs.dev
- Community Support: Laravel Discord, Laracasts Forums
