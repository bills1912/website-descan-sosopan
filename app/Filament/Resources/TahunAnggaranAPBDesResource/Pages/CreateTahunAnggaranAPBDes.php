<?php

namespace App\Filament\Resources\TahunAnggaranAPBDesResource\Pages;

use App\Filament\Resources\TahunAnggaranAPBDesResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateTahunAnggaranAPBDes extends CreateRecord
{
    protected static string $resource = TahunAnggaranAPBDesResource::class;
    protected static bool $canCreateAnother = false;

    //customize redirect after create
    public function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
