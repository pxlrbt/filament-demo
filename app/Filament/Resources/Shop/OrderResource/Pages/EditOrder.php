<?php

namespace App\Filament\Resources\Shop\OrderResource\Pages;

use App\Filament\Resources\Shop\OrderResource;
use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord;

class EditOrder extends EditRecord
{
    protected static string $resource = OrderResource::class;

    protected function getActions(): array
    {
        return [
            Actions\Action::make('test')
                ->action(
                    fn () => Notification::make()
                        ->title('You sure?')
                        ->actions([
                            Actions\DeleteAction::make()
                                ->compo
                                ->record($this->record),
                        ])
                        ->send()
                ),

            Actions\DeleteAction::make(),
            Actions\RestoreAction::make(),
            Actions\ForceDeleteAction::make(),
        ];
    }
}
