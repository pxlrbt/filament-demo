# Plugin Playground

Documentation about the plugins installed for testing/development.

## Activity Log

- Customer: https://v4.filament.test/shop/customers → clock icon per row
- Author: https://v4.filament.test/blog/authors → clock icon per row
- `LogsActivity` lives on `Shop\Customer` and `Blog\Author`; edit a record to generate entries

## Changelog Pro
 
- Page: https://v4.filament.test/changelog-page
- Widget https://v4.filament.test/
- Version Badge in Topbar
- For testing the modal, uncomment code in AdminPanelProvider 

## Environment Indicator

- Badge/Border Topbar
- Set `APP_ENVIRONMENT=production` & `APP_DEBUG=true` for testing debug warning 

## Excel

- Header action with two configured exports (table/form): https://v4.filament.test/blog/authors
- Plain bulk export: https://v4.filament.test/shop/products/products
- Linked under the "Packages" navigation group for quick access
- Installed from the `feature/laravel-excel-v4` branch, aliased as `dev-main`

## Favicon

- FaviconColumn & FaviconEntry: https://v4.filament.test/favicon-page

## Image Compare

- ImageCompareEntry: https://v4.filament.test/image-compare-page

## Spotlight Pro

- Configuration in [Provider](./app/Providers/Filament/AdminPanelProvider.php)
- Test FrankenPHP Octane `php artisan octane:frankenphp --workers=2`

## Not installed

- **Spotlight (free)** — superseded by Spotlight Pro. Plugin IDs differ so both would
  load, but they compete for the same palette. Swap, don't stack.
- **Translate Action** — needs `spatie/laravel-translatable`, which upstream removed in
  "Remove links/translatable". Requires re-adding `HasTranslations` to a model plus a
  locale switcher, and a DeepL API key.
