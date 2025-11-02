<?php

namespace App\Filament\Resources\Shop\CustomerResource\Resources\Orders;

use App\Filament\Resources\Shop\CustomerResource;
use App\Filament\Resources\Shop\CustomerResource\Resources\Orders\Pages\CreateOrder;
use App\Filament\Resources\Shop\CustomerResource\Resources\Orders\Pages\EditOrder;
use App\Filament\Resources\Shop\CustomerResource\Resources\Orders\Pages\ViewOrder;
use App\Filament\Resources\Shop\CustomerResource\Resources\Orders\Schemas\OrderForm;
use App\Filament\Resources\Shop\CustomerResource\Resources\Orders\Schemas\OrderInfolist;
use App\Filament\Resources\Shop\CustomerResource\Resources\Orders\Tables\OrdersTable;
use App\Models\Shop\Order;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class OrderResource extends Resource
{
    protected static ?string $model = Order::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $parentResource = CustomerResource::class;

    protected static ?string $recordTitleAttribute = 'number';

    public static function form(Schema $schema): Schema
    {
        return OrderForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return OrderInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return OrdersTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            CustomerResource\Resources\Orders\RelationManagers\PaymentsRelationManager::class
        ];
    }

    public static function getPages(): array
    {
        return [
            'create' => CreateOrder::route('/create'),
            'view' => ViewOrder::route('/{record}'),
            'edit' => EditOrder::route('/{record}/edit'),
        ];
    }

    public static function getRecordRouteBindingEloquentQuery(): Builder
    {
        return parent::getRecordRouteBindingEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }
}
