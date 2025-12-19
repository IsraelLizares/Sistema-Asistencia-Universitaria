<?php

namespace App\Filament\Resources\ParamMaterias\Pages;

use App\Filament\Resources\ParamMaterias\ParamMateriaResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListParamMaterias extends ListRecords
{
    protected static string $resource = ParamMateriaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
