<?php

namespace App\Filament\Resources\ParamSemestres;

use App\Filament\Resources\ParamSemestres\Pages\CreateParamSemestre;
use App\Filament\Resources\ParamSemestres\Pages\EditParamSemestre;
use App\Filament\Resources\ParamSemestres\Pages\ListParamSemestres;
use App\Filament\Resources\ParamSemestres\Pages\ViewParamSemestre;
use App\Filament\Resources\ParamSemestres\Schemas\ParamSemestreForm;
use App\Filament\Resources\ParamSemestres\Schemas\ParamSemestreInfolist;
use App\Filament\Resources\ParamSemestres\Tables\ParamSemestresTable;
use App\Models\ParamSemestre;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class ParamSemestreResource extends Resource
{
    protected static ?string $model = ParamSemestre::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'nombre_semestre';

    public static function form(Schema $schema): Schema
    {
        return ParamSemestreForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return ParamSemestreInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ParamSemestresTable::configure($table);
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
            'index' => ListParamSemestres::route('/'),
            'create' => CreateParamSemestre::route('/create'),
            'view' => ViewParamSemestre::route('/{record}'),
            'edit' => EditParamSemestre::route('/{record}/edit'),
        ];
    }
}
