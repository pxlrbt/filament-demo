<?php

namespace App\Filament\Resources\Shop\Customers\Resources\Orders\Pages;

use App\Filament\Resources\Shop\Customers\Resources\Orders\OrderResource;
use Filament\Resources\Pages\CreateRecord;

class CreateOrder extends CreateRecord
{
    protected static string $resource = OrderResource::class;
}
