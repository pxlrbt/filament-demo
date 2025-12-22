<?php

namespace App\Filament\Resources\Shop\Customers\Resources\Orders\Resources\Payments;

use App\Filament\Resources\Shop\Customers\Resources\Orders\OrderResource;
use App\Filament\Resources\Shop\Customers\Resources\Orders\Resources\Payments\Pages\CreatePayment;
use App\Filament\Resources\Shop\Customers\Resources\Orders\Resources\Payments\Pages\EditPayment;
use App\Filament\Resources\Shop\Customers\Resources\Orders\Resources\Payments\Pages\ViewPayment;
use App\Filament\Resources\Shop\Customers\Resources\Orders\Resources\Payments\Schemas\PaymentForm;
use App\Filament\Resources\Shop\Customers\Resources\Orders\Resources\Payments\Schemas\PaymentInfolist;
use App\Filament\Resources\Shop\Customers\Resources\Orders\Resources\Payments\Tables\PaymentsTable;
use App\Models\Shop\Payment;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class PaymentResource extends Resource
{
    protected static ?string $model = Payment::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $parentResource = OrderResource::class;

    protected static ?string $recordTitleAttribute = 'reference';

    public static function form(Schema $schema): Schema
    {
        return PaymentForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return PaymentInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return PaymentsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'create' => CreatePayment::route('/create'),
            'view' => ViewPayment::route('/{record}'),
            'edit' => EditPayment::route('/{record}/edit'),
        ];
    }
}
