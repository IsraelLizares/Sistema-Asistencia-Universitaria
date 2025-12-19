<?php

namespace App\Filament\Resources\ParamMaterias\Pages;

use App\Filament\Resources\ParamMaterias\ParamMateriaResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditParamMateria extends EditRecord
{
    protected static string $resource = ParamMateriaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
