<?php

namespace App\Filament\Resources\ParamCarreras\Pages;

use App\Filament\Resources\ParamCarreras\ParamCarreraResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListParamCarreras extends ListRecords
{
    protected static string $resource = ParamCarreraResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
