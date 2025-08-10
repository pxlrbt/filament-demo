<?php

namespace App\Filament\Widgets;

use Filament\Widgets\Widget;

class ThemeColorsWidget extends Widget
{
    protected string $view = 'filament.widgets.theme-colors';

    protected static ?int $sort = -10;

    protected int | string | array $columnSpan = 2;

    public function getColors(): array
    {
        return ['primary', 'info', 'success', 'warning', 'danger'];
    }
}
