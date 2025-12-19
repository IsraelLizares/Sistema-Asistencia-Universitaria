<?php

namespace App\Filament\Resources\ParamRols\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class ParamRolForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('rol')
                    ->required(),
                TextInput::make('estado')
                    ->required()
                    ->numeric()
                    ->default(1),
            ]);
    }
}
