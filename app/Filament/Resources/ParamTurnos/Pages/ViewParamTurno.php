<?php

namespace App\Filament\Resources\ParamTurnos\Pages;

use App\Filament\Resources\ParamTurnos\ParamTurnoResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewParamTurno extends ViewRecord
{
    protected static string $resource = ParamTurnoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
