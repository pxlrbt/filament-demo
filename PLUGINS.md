# Plugin Playground

Documentation about the plugins installed for testing/development.

## Changelog Pro
 
- Page: https://v4.filament.test/changelog-page
- Widget https://v4.filament.test/
- Version Badge in Topbar
- For testing the modal, uncomment code in AdminPanelProvider 

## Environment Indicator

- Badge/Border Topbar
- Set `APP_ENVIRONMENT=production` & `APP_DEBUG=true` for testing debug warning 

## Favicon

- FaviconColumn & FaviconEntry: https://v4.filament.test/favicon-page

## Image Compare

- ImageCompareEntry: https://v4.filament.test/image-compare-page

## Spotlight Pro

- Configuration in [Provider](./app/Providers/Filament/AdminPanelProvider.php)
- Test FrankenPHP Octane `php artisan octane:frankenphp --workers=2`
