<?php

namespace App\Filament\Resources\ParamRols;

use App\Filament\Resources\ParamRols\Pages\CreateParamRol;
use App\Filament\Resources\ParamRols\Pages\EditParamRol;
use App\Filament\Resources\ParamRols\Pages\ListParamRols;
use App\Filament\Resources\ParamRols\Pages\ViewParamRol;
use App\Filament\Resources\ParamRols\Schemas\ParamRolForm;
use App\Filament\Resources\ParamRols\Schemas\ParamRolInfolist;
use App\Filament\Resources\ParamRols\Tables\ParamRolsTable;
use App\Models\ParamRol;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class ParamRolResource extends Resource
{
    protected static ?string $model = ParamRol::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'ParamRol';

    public static function form(Schema $schema): Schema
    {
        return ParamRolForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return ParamRolInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ParamRolsTable::configure($table);
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
            'index' => ListParamRols::route('/'),
            'create' => CreateParamRol::route('/create'),
            'view' => ViewParamRol::route('/{record}'),
            'edit' => EditParamRol::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->where('estado', 1);
    }
}
