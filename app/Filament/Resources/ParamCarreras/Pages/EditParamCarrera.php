<?php

namespace App\Filament\Resources\ParamCarreras\Pages;

use App\Filament\Resources\ParamCarreras\ParamCarreraResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditParamCarrera extends EditRecord
{
    protected static string $resource = ParamCarreraResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
