<?php

namespace App\Filament\Resources\TahunAnggaranAPBDesResource\Pages;

use App\Filament\Resources\TahunAnggaranAPBDesResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditTahunAnggaranAPBDes extends EditRecord
{
    protected static string $resource = TahunAnggaranAPBDesResource::class;

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
