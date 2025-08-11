<?php

namespace App\Filament\Resources\KegiatanDesaResource\Pages;

use App\Filament\Resources\KegiatanDesaResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditKegiatanDesa extends EditRecord
{
    protected static string $resource = KegiatanDesaResource::class;

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
