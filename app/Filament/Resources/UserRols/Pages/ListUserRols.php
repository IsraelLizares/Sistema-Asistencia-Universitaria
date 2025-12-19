<?php

namespace App\Filament\Resources\UserRols\Pages;

use App\Filament\Resources\UserRols\UserRolResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListUserRols extends ListRecords
{
    protected static string $resource = UserRolResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
