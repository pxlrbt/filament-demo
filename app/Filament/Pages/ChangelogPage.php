<?php

namespace App\Filament\Pages;

use App\Enums\NavigationGroup;
use Filament\Pages\Page;
use UnitEnum;

class ChangelogPage extends \pxlrbt\FilamentChangelog\Filament\Pages\ChangelogPage
{
    protected static string | UnitEnum | null $navigationGroup = NavigationGroup::Packages;
}
