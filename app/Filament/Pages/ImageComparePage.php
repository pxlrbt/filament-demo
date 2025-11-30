<?php

namespace App\Filament\Pages;

use App\Enums\NavigationGroup;
use App\Models\Blog\Link;
use Filament\Pages\Page;
use Filament\Schemas\Components\EmbeddedSchema;
use Filament\Schemas\Schema;
use pxlrbt\FilamentImageCompare\Filament\ImageCompareEntry;
use UnitEnum;

class ImageComparePage extends Page
{
    protected static string | UnitEnum | null $navigationGroup = NavigationGroup::Packages;

    public function infolist(Schema $schema): Schema
    {
        $linkA = Link::find(1);
        $linkB = Link::find(2);

        return $schema->components([
            ImageCompareEntry::make()
                ->leftImage($linkA->image)
                ->rightImage($linkB->image),
        ]);
    }


    public function content(Schema $schema): Schema
    {
        return $schema->components([
            EmbeddedSchema::make('infolist')
        ]);
    }
}
