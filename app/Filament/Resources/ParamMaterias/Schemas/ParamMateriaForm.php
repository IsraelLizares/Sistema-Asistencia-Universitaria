<?php

namespace App\Filament\Resources\ParamMaterias\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class ParamMateriaForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('nombre_materia')
                    ->required(),
                TextInput::make('codigo_materia')
                    ->required(),
                TextInput::make('id_carrera')
                    ->required()
                    ->numeric(),
                Toggle::make('estado')
                    ->required(),
            ]);
    }
}
