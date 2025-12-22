<?php

namespace App\Filament\Resources\Blog\Categories\Pages;

use App\Filament\Imports\Blog\CategoryImporter;
use App\Filament\Resources\Blog\Categories\CategoryResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageCategories extends ManageRecords
{
    protected static string $resource = CategoryResource::class;

    protected function getActions(): array
    {
        return [
            Actions\ImportAction::make()
                ->importer(CategoryImporter::class),
            Actions\CreateAction::make(),
        ];
    }
}
