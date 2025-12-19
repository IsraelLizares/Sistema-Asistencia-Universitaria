<?php

namespace App\Filament\Resources\ParamAulas\Pages;

use App\Filament\Resources\ParamAulas\ParamAulaResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewParamAula extends ViewRecord
{
    protected static string $resource = ParamAulaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
