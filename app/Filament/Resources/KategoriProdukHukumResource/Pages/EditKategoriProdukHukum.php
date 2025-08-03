<?php

namespace App\Filament\Resources\KategoriProdukHukumResource\Pages;

use App\Filament\Resources\KategoriProdukHukumResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditKategoriProdukHukum extends EditRecord
{
    protected static string $resource = KategoriProdukHukumResource::class;

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
