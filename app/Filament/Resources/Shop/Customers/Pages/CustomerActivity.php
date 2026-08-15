<?php

namespace App\Filament\Resources\Shop\Customers\Pages;

use App\Filament\Resources\Shop\Customers\CustomerResource;
use pxlrbt\FilamentActivityLog\Pages\ListActivities;

class CustomerActivity extends ListActivities
{
    protected static string $resource = CustomerResource::class;
}
