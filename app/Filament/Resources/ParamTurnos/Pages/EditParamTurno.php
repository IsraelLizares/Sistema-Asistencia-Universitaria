<?php

namespace App\Filament\Resources\ParamTurnos\Pages;

use App\Filament\Resources\ParamTurnos\ParamTurnoResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditParamTurno extends EditRecord
{
    protected static string $resource = ParamTurnoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
