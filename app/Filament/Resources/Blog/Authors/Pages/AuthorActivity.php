<?php

namespace App\Filament\Resources\Blog\Authors\Pages;

use App\Filament\Resources\Blog\Authors\AuthorResource;
use pxlrbt\FilamentActivityLog\Pages\ListActivities;

class AuthorActivity extends ListActivities
{
    protected static string $resource = AuthorResource::class;
}
