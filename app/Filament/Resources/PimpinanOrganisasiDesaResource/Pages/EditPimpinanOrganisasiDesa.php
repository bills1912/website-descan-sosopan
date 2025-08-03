<?php

namespace App\Filament\Resources\PimpinanOrganisasiDesaResource\Pages;

use App\Filament\Resources\PimpinanOrganisasiDesaResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPimpinanOrganisasiDesa extends EditRecord
{
    protected static string $resource = PimpinanOrganisasiDesaResource::class;

    protected function getHeaderActions(): array
    {
        return [
        ];
    }

    //customize redirect after create
    public function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
