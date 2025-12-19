<?php

namespace App\Filament\Resources\ParamCarreras\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class ParamCarreraForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('nombre_carrera')
                    ->required(),
                Textarea::make('descripcion')
                    ->columnSpanFull(),
                Toggle::make('estado')
                    ->required(),
            ]);
    }
}
