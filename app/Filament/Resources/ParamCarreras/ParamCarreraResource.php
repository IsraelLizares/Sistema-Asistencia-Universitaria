<?php

namespace App\Filament\Resources\ParamCarreras;

use App\Filament\Resources\ParamCarreras\Pages\CreateParamCarrera;
use App\Filament\Resources\ParamCarreras\Pages\EditParamCarrera;
use App\Filament\Resources\ParamCarreras\Pages\ListParamCarreras;
use App\Filament\Resources\ParamCarreras\Pages\ViewParamCarrera;
use App\Filament\Resources\ParamCarreras\Schemas\ParamCarreraForm;
use App\Filament\Resources\ParamCarreras\Schemas\ParamCarreraInfolist;
use App\Filament\Resources\ParamCarreras\Tables\ParamCarrerasTable;
use App\Models\ParamCarrera;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class ParamCarreraResource extends Resource
{
    protected static ?string $model = ParamCarrera::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'nombre_carrera';

    public static function form(Schema $schema): Schema
    {
        return ParamCarreraForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return ParamCarreraInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ParamCarrerasTable::configure($table);
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
            'index' => ListParamCarreras::route('/'),
            'create' => CreateParamCarrera::route('/create'),
            'view' => ViewParamCarrera::route('/{record}'),
            'edit' => EditParamCarrera::route('/{record}/edit'),
        ];
    }
}
