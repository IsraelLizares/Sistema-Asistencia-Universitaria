<?php

namespace App\Filament\Resources\ParamAulas\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class ParamAulaForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('codigo_aula')
                    ->required(),
                TextInput::make('capacidad')
                    ->required()
                    ->numeric()
                    ->default(30),
                TextInput::make('tipo')
                    ->required()
                    ->default('teorica'),
                Toggle::make('estado')
                    ->required(),
            ]);
    }
}
