<?php

namespace App\Filament\Resources\Blog\AuthorResource\Pages;

use App\Filament\Exports\Blog\AuthorExporter;
use App\Filament\Resources\Blog\AuthorResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;
use pxlrbt\FilamentActivityLog\Pages\ListActivities;

class ListAuthorActivities extends ListActivities
{
    protected static string $resource = AuthorResource::class;
}
