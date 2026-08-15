<?php

namespace App\Filament\Resources\Blog\Authors\Tables;

use App\Filament\Resources\Blog\Authors\AuthorResource;
use Filament\Actions\Action;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Notifications\Notification;
use Filament\Tables\Columns\Layout\Split;
use Filament\Tables\Columns\Layout\Stack;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use pxlrbt\FilamentExcel\Actions\ExportAction;
use pxlrbt\FilamentExcel\Actions\ExportBulkAction;
use pxlrbt\FilamentExcel\Columns\Column;
use pxlrbt\FilamentExcel\Exports\ExcelExport;

class AuthorsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                Split::make([
                    Stack::make([
                        TextColumn::make('name')
                            ->searchable()
                            ->sortable()
                            ->weight('medium')
                            ->alignLeft(),

                        TextColumn::make('email')
                            ->label('Email address')
                            ->searchable()
                            ->sortable()
                            ->color('gray')
                            ->alignLeft(),
                    ])->space(),

                    Stack::make([
                        TextColumn::make('github_handle')
                            ->icon('icon-github')
                            ->label('GitHub handle')
                            ->alignLeft(),

                        TextColumn::make('twitter_handle')
                            ->icon('icon-twitter')
                            ->alignLeft(),
                    ])->space(2),
                ])->from('md'),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                ExportAction::make()->exports([
                    ExcelExport::make('table')
                        ->fromTable()
                        ->except('email')
                        ->withNamesAsHeadings()
                        ->withColumns([
                            Column::make('bio')->heading('BIO'),
                        ])
                        ->withFilename('authors-table'),
                    ExcelExport::make('form')
                        ->fromForm()
                        ->withFilename('authors-form'),
                ]),
            ])
            ->recordActions([
                Action::make('activities')
                    ->icon('heroicon-o-clock')
                    ->url(fn ($record): string => AuthorResource::getUrl('activities', ['record' => $record])),
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->groupedBulkActions([
                ExportBulkAction::make(),
                DeleteBulkAction::make()
                    ->action(function (): void {
                        Notification::make()
                            ->title('Now, now, don\'t be cheeky, leave some records for others to play with!')
                            ->warning()
                            ->send();
                    }),
            ]);
    }
}
