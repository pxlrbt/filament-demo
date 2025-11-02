<?php

namespace App\Filament\Resources\Shop\CustomerResource\Resources\Orders\Pages;

use App\Filament\Resources\Shop\CustomerResource\Resources\Orders\OrderResource;
use Filament\Resources\Pages\CreateRecord;

class CreateOrder extends CreateRecord
{
    protected static string $resource = OrderResource::class;
}
