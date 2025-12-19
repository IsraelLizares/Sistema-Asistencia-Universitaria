<?php

namespace App\Filament\Resources\ParamRols\Pages;

use App\Filament\Resources\ParamRols\ParamRolResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewParamRol extends ViewRecord
{
    protected static string $resource = ParamRolResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
