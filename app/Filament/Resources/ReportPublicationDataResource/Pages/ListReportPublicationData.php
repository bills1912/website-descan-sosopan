<?php

namespace App\Filament\Resources\ReportPublicationDataResource\Pages;

use App\Filament\Resources\ReportPublicationDataResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListReportPublicationData extends ListRecords
{
    protected static string $resource = ReportPublicationDataResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
