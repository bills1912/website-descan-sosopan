<?php

namespace App\Filament\Resources\AgendaDesaResource\Pages;

use App\Filament\Resources\AgendaDesaResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateAgendaDesa extends CreateRecord
{
    protected static string $resource = AgendaDesaResource::class;
    protected static bool $canCreateAnother = false;

    //customize redirect after create
    public function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
