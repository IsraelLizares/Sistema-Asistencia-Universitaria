<?php

namespace App\Filament\Resources\UserRols\Pages;

use App\Filament\Resources\UserRols\UserRolResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditUserRol extends EditRecord
{
    protected static string $resource = UserRolResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
