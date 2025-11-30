<?php

namespace App\Filament\Pages;

use App\Enums\NavigationGroup;
use Filament\Actions\Action;
use Filament\Infolists\Components\TextEntry;
use Filament\Pages\Page;
use Filament\Schemas\Components\EmbeddedTable;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use pxlrbt\FilamentFavicon\Filament\FaviconColumn;
use pxlrbt\FilamentFavicon\Filament\FaviconEntry;
use UnitEnum;

class FaviconPage extends Page implements HasTable
{
    use InteractsWithTable;

    protected static string | UnitEnum | null $navigationGroup = NavigationGroup::Packages;

    public function content(Schema $schema): Schema
    {
        return $schema->components([
            EmbeddedTable::make()
        ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->records(function () {
                $domains = collect([
                    'google.com',
                    'wikipedia.org',
                    'youtube.com',
                    'facebook.com',
                    'twitter.com',
                    'instagram.com',
                    'linkedin.com',
                    'github.com',
                    'stackoverflow.com',
                    'reddit.com',
                    'amazon.com',
                    'netflix.com',
                    'apple.com',
                    'microsoft.com',
                    'yahoo.com',
                ]);

                return $domains->mapWithKeys(fn ($domain, $index) => [
                    $index => [
                        'favicon' => $domain,
                        'domain' => $domain,
                    ]
                ])->toArray();
            })
            ->columns([
                FaviconColumn::make('favicon')
                    ->label('Favion'),

                TextColumn::make('domain')
                    ->label('Domain'),
            ])
            ->recordActions([
                Action::make('view')
                    ->fillForm(fn (array $record) => $record)
                    ->schema([
                        FaviconEntry::make('favicon')->label('Favicon'),
                        TextEntry::make('domain')->label('Domain'),
                    ])
            ])
            ->recordAction('view');
    }
}
