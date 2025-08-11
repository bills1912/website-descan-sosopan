<?php

namespace App\Filament\Resources\KegiatanDesaResource\Pages;

use App\Filament\Resources\KegiatanDesaResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateKegiatanDesa extends CreateRecord
{
    protected static string $resource = KegiatanDesaResource::class;
    protected static bool $canCreateAnother = false;

    //customize redirect after create
    public function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
