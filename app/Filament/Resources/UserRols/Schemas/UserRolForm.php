<?php

namespace App\Filament\Resources\UserRols\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Schemas\Schema;

use App\Models\User;
use App\Models\ParamRol;

class UserRolForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                // TextInput::make('id_user')
                //     ->required()
                //     ->numeric(),
                // TextInput::make('id_rol')
                //     ->required()
                //     ->numeric(),
                Select::make('id_user')
                    ->label('Usuario')
                    ->options(User::pluck('name', 'id'))
                    ->searchable()
                    ->required(),
                Select::make('id_rol')
                    ->label('Rol')
                    ->options(ParamRol::where('estado', 1)->pluck('rol', 'id'))
                    ->searchable()
                    ->required(),
                TextInput::make('estado')
                    ->required()
                    ->numeric()
                    ->default(1),
            ]);
    }
}
