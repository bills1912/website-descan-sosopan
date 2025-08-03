<?php

namespace App\Filament\Resources\PimpinanOrganisasiDesaResource\Pages;

use App\Filament\Resources\PimpinanOrganisasiDesaResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreatePimpinanOrganisasiDesa extends CreateRecord
{
    protected static string $resource = PimpinanOrganisasiDesaResource::class;
    protected static bool $canCreateAnother = false;

    //customize redirect after create
    public function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
