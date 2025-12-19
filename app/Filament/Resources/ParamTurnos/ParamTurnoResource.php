<?php

namespace App\Filament\Resources\ParamTurnos;

use App\Filament\Resources\ParamTurnos\Pages\CreateParamTurno;
use App\Filament\Resources\ParamTurnos\Pages\EditParamTurno;
use App\Filament\Resources\ParamTurnos\Pages\ListParamTurnos;
use App\Filament\Resources\ParamTurnos\Pages\ViewParamTurno;
use App\Filament\Resources\ParamTurnos\Schemas\ParamTurnoForm;
use App\Filament\Resources\ParamTurnos\Schemas\ParamTurnoInfolist;
use App\Filament\Resources\ParamTurnos\Tables\ParamTurnosTable;
use App\Models\ParamTurno;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class ParamTurnoResource extends Resource
{
    protected static ?string $model = ParamTurno::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'nombre_turno';

    public static function form(Schema $schema): Schema
    {
        return ParamTurnoForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return ParamTurnoInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ParamTurnosTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListParamTurnos::route('/'),
            'create' => CreateParamTurno::route('/create'),
            'view' => ViewParamTurno::route('/{record}'),
            'edit' => EditParamTurno::route('/{record}/edit'),
        ];
    }
}
