<?php

namespace App\Filament\Resources\ParamRols\Pages;

use App\Filament\Resources\ParamRols\ParamRolResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListParamRols extends ListRecords
{
    protected static string $resource = ParamRolResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
