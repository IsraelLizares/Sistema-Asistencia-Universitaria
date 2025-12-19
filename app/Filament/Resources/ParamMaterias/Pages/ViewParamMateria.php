<?php

namespace App\Filament\Resources\ParamMaterias\Pages;

use App\Filament\Resources\ParamMaterias\ParamMateriaResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewParamMateria extends ViewRecord
{
    protected static string $resource = ParamMateriaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
