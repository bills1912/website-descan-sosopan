<?php

namespace App\Filament\Resources\KategoriProdukHukumResource\Pages;

use App\Filament\Resources\KategoriProdukHukumResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateKategoriProdukHukum extends CreateRecord
{
    protected static string $resource = KategoriProdukHukumResource::class;
    protected static bool $canCreateAnother = false;

    //customize redirect after create
    public function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
