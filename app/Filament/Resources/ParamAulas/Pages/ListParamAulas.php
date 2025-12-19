<?php

namespace App\Filament\Resources\ParamAulas\Pages;

use App\Filament\Resources\ParamAulas\ParamAulaResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListParamAulas extends ListRecords
{
    protected static string $resource = ParamAulaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
