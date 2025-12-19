<?php

namespace App\Filament\Resources\ParamAulas\Pages;

use App\Filament\Resources\ParamAulas\ParamAulaResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditParamAula extends EditRecord
{
    protected static string $resource = ParamAulaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
