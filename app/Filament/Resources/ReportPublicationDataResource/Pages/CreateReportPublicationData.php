<?php

namespace App\Filament\Resources\ReportPublicationDataResource\Pages;

use App\Filament\Resources\ReportPublicationDataResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateReportPublicationData extends CreateRecord
{
    protected static string $resource = ReportPublicationDataResource::class;
    protected static bool $canCreateAnother = false;

    //customize redirect after create
    public function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
