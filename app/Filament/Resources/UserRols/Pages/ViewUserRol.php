<?php

namespace App\Filament\Resources\UserRols\Pages;

use App\Filament\Resources\UserRols\UserRolResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewUserRol extends ViewRecord
{
    protected static string $resource = UserRolResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
