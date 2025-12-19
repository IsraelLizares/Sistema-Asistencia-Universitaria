<?php

namespace App\Filament\Resources\ParamSemestres\Pages;

use App\Filament\Resources\ParamSemestres\ParamSemestreResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListParamSemestres extends ListRecords
{
    protected static string $resource = ParamSemestreResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
