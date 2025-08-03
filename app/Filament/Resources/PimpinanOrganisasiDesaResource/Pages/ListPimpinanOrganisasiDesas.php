<?php

namespace App\Filament\Resources\PimpinanOrganisasiDesaResource\Pages;

use App\Filament\Resources\PimpinanOrganisasiDesaResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListPimpinanOrganisasiDesas extends ListRecords
{
    protected static string $resource = PimpinanOrganisasiDesaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
