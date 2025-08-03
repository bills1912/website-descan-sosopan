<?php

namespace App\Filament\Resources\KategoriProdukHukumResource\Pages;

use App\Filament\Resources\KategoriProdukHukumResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListKategoriProdukHukums extends ListRecords
{
    protected static string $resource = KategoriProdukHukumResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
