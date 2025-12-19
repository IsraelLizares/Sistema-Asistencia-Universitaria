<?php

namespace App\Filament\Resources\ParamSemestres\Pages;

use App\Filament\Resources\ParamSemestres\ParamSemestreResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditParamSemestre extends EditRecord
{
    protected static string $resource = ParamSemestreResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
