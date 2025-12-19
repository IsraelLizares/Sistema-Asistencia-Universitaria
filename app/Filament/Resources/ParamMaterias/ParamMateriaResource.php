<?php

namespace App\Filament\Resources\ParamMaterias;

use App\Filament\Resources\ParamMaterias\Pages\CreateParamMateria;
use App\Filament\Resources\ParamMaterias\Pages\EditParamMateria;
use App\Filament\Resources\ParamMaterias\Pages\ListParamMaterias;
use App\Filament\Resources\ParamMaterias\Pages\ViewParamMateria;
use App\Filament\Resources\ParamMaterias\Schemas\ParamMateriaForm;
use App\Filament\Resources\ParamMaterias\Schemas\ParamMateriaInfolist;
use App\Filament\Resources\ParamMaterias\Tables\ParamMateriasTable;
use App\Models\ParamMateria;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class ParamMateriaResource extends Resource
{
    protected static ?string $model = ParamMateria::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'nombre_materia';

    public static function form(Schema $schema): Schema
    {
        return ParamMateriaForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return ParamMateriaInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ParamMateriasTable::configure($table);
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
            'index' => ListParamMaterias::route('/'),
            'create' => CreateParamMateria::route('/create'),
            'view' => ViewParamMateria::route('/{record}'),
            'edit' => EditParamMateria::route('/{record}/edit'),
        ];
    }
}
