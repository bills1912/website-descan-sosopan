<?php

namespace App\Filament\Resources\ReportPublicationDataResource\Pages;

use App\Filament\Resources\ReportPublicationDataResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditReportPublicationData extends EditRecord
{
    protected static string $resource = ReportPublicationDataResource::class;

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
