<?php

namespace App\Filament\Resources\ParamSemestres\Pages;

use App\Filament\Resources\ParamSemestres\ParamSemestreResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewParamSemestre extends ViewRecord
{
    protected static string $resource = ParamSemestreResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
