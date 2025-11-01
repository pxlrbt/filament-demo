<?php

namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasLabel;

enum NavigationGroup: string implements HasLabel
{
    case Blog = 'blog';

    public function getLabel(): string
    {
        return match ($this) {
            self::Blog => 'Blog',
        };
    }

}
