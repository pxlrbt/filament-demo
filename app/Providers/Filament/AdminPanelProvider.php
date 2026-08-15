<?php

namespace App\Providers\Filament;

use App\Enums\NavigationGroup;
use App\Filament\Clusters\Products\Resources\Products\ProductResource;
use App\Filament\Pages\Auth\Login;
use App\Filament\Pages\Dashboard;
use App\Filament\Resources\Blog\Authors\AuthorResource;
use App\Filament\Resources\Shop\Customers\CustomerResource;
use App\Http\Middleware\Authenticate;
use App\Models\Blog\Author;
use App\Models\Shop\Customer;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Navigation\NavigationItem;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\Support\Icons\Heroicon;
use Filament\Widgets\AccountWidget;
use Filament\Widgets\FilamentInfoWidget;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\AuthenticateSession;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use pxlrbt\FilamentChangelog\ChangelogPlugin;
use pxlrbt\FilamentChangelog\Filament\Widgets\ChangelogWidget;
use pxlrbt\FilamentEnvironmentIndicator\EnvironmentIndicatorPlugin;
use pxlrbt\FilamentSpotlightPro\SpotlightCommands\ChangePanelCommand;
use pxlrbt\FilamentSpotlightPro\SpotlightPlugin;
use pxlrbt\FilamentSpotlightPro\SpotlightProviders\RegisterCommands;
use pxlrbt\FilamentSpotlightPro\SpotlightProviders\RegisterPages;
use pxlrbt\FilamentSpotlightPro\SpotlightProviders\RegisterResources;

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        // ChangePanelCommand::panelLabels([
        //     'admin' => 'Adminbereich',
        //     'app' => 'App'
        // ]);
        //
        // ChangePanelCommand::panelIcons([
        //     'admin' => Heroicon::AcademicCap,
        //     'app' => Heroicon::User
        // ]);

        $panel
            ->default()
            ->id('admin')
            ->login(Login::class)
            ->viteTheme('resources/css/filament/admin/theme.css')
            ->discoverClusters(in: app_path('Filament/Clusters'), for: 'App\\Filament\\Clusters')
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\\Filament\\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\\Filament\\Pages')
            ->pages([
                Dashboard::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\\Filament\\Widgets')
            ->widgets([
                AccountWidget::class,
                FilamentInfoWidget::class,
            ])
            ->unsavedChangesAlerts()
            ->brandLogo(fn () => view('filament.app.logo'))
            ->brandLogoHeight('1.25rem')
            ->navigationGroups([
                'Shop',
                'Blog',
            ])
            ->databaseNotifications()
            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                VerifyCsrfToken::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
            ])
            ->authMiddleware([
                Authenticate::class,
            ])
            ->spa()
            ->colors([
                'primary' => Color::Blue,
            ]);

        $this->registerActivityLogLinks($panel);
        $this->registerExcelLinks($panel);
        $this->registerSpotlightPlugin($panel);
        $this->registerChangelogPlugin($panel);
        $this->registerEnvironmentIndicator($panel);

        return $panel;
    }

    public function registerExcelLinks(Panel $panel): Panel
    {
        return $panel->navigationItems([
            NavigationItem::make('Excel: Authors')
                ->icon(Heroicon::OutlinedTableCells)
                ->group(NavigationGroup::Packages)
                ->url(fn (): string => AuthorResource::getUrl()),
            NavigationItem::make('Excel: Products')
                ->icon(Heroicon::OutlinedTableCells)
                ->group(NavigationGroup::Packages)
                ->url(fn (): string => ProductResource::getUrl()),
        ]);
    }

    public function registerActivityLogLinks(Panel $panel): Panel
    {
        return $panel->navigationItems([
            NavigationItem::make('Activity Log: Customer')
                ->icon(Heroicon::OutlinedClock)
                ->group(NavigationGroup::Packages)
                ->visible(fn (): bool => Customer::query()->exists())
                ->url(fn (): string => CustomerResource::getUrl('activities', [
                    'record' => Customer::query()->value('id'),
                ])),
            NavigationItem::make('Activity Log: Author')
                ->icon(Heroicon::OutlinedClock)
                ->group(NavigationGroup::Packages)
                ->visible(fn (): bool => Author::query()->exists())
                ->url(fn (): string => AuthorResource::getUrl('activities', [
                    'record' => Author::query()->value('id'),
                ])),
        ]);
    }

    public function registerSpotlightPlugin(Panel $panel): Panel
    {
        return $panel->plugin(
            SpotlightPlugin::make()
                // ->hideGlobalSearch()
                // ->replaceGlobalSearch()
                ->registerItems([
                    RegisterResources::make(),
                    RegisterPages::make(),
                    RegisterCommands::make(),
                ]),
        );
    }

    public function registerChangelogPlugin(Panel $panel): Panel
    {
        return $panel
            ->widgets([
                ChangelogWidget::class,
            ])
            ->plugin(
                ChangelogPlugin::make()
                    ->github(config('services.github.repo'), config('services.github.token'))
                    ->showVersionBadge()
                // ->showNewVersionModal()
            );
    }

    public function registerEnvironmentIndicator(Panel $panel): Panel
    {
        $panel
            ->plugin(
                EnvironmentIndicatorPlugin::make()
                    ->color(fn () => Color::Pink)
                    ->showBorder()
                    ->showGitBranch()
                    ->showDebugModeWarningInProduction()
            );

        return $panel;
    }
}
