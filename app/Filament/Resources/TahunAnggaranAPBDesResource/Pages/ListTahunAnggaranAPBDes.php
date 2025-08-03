<?php

namespace App\Filament\Resources\TahunAnggaranAPBDesResource\Pages;

use App\Filament\Resources\TahunAnggaranAPBDesResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListTahunAnggaranAPBDes extends ListRecords
{
    protected static string $resource = TahunAnggaranAPBDesResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
