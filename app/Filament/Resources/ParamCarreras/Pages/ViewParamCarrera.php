<?php

namespace App\Filament\Resources\ParamCarreras\Pages;

use App\Filament\Resources\ParamCarreras\ParamCarreraResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewParamCarrera extends ViewRecord
{
    protected static string $resource = ParamCarreraResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
