<?php

namespace App\Filament\Resources\KegiatanDesaResource\Pages;

use App\Filament\Resources\KegiatanDesaResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListKegiatanDesas extends ListRecords
{
    protected static string $resource = KegiatanDesaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
