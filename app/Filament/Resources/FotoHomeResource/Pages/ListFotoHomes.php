<?php

namespace App\Filament\Resources\FotoHomeResource\Pages;

use App\Filament\Resources\FotoHomeResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListFotoHomes extends ListRecords
{
    protected static string $resource = FotoHomeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
