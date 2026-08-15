<?php

namespace App\Filament\Pages;

use App\Enums\NavigationGroup;
use App\Models\Blog\Post;
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
        $posts = Post::query()->take(2)->get();

        return $schema->components([
            ImageCompareEntry::make()
                ->leftImage($posts->first()?->getFirstMediaUrl('post-images'))
                ->rightImage($posts->last()?->getFirstMediaUrl('post-images')),
        ]);
    }

    public function content(Schema $schema): Schema
    {
        return $schema->components([
            EmbeddedSchema::make('infolist'),
        ]);
    }
}
