<?php

namespace App\Filament\Resources\ParamRols\Pages;

use App\Filament\Resources\ParamRols\ParamRolResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditParamRol extends EditRecord
{
    protected static string $resource = ParamRolResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
