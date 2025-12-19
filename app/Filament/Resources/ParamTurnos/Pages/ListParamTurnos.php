<?php

namespace App\Filament\Resources\ParamTurnos\Pages;

use App\Filament\Resources\ParamTurnos\ParamTurnoResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListParamTurnos extends ListRecords
{
    protected static string $resource = ParamTurnoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
