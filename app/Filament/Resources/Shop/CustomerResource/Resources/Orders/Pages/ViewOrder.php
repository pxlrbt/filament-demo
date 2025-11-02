<?php

namespace App\Filament\Resources\Shop\CustomerResource\Resources\Orders\Pages;

use App\Filament\Resources\Shop\CustomerResource\Resources\Orders\OrderResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewOrder extends ViewRecord
{
    protected static string $resource = OrderResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
