<?php

namespace App\Filament\Resources\ParamAulas;

use App\Filament\Resources\ParamAulas\Pages\CreateParamAula;
use App\Filament\Resources\ParamAulas\Pages\EditParamAula;
use App\Filament\Resources\ParamAulas\Pages\ListParamAulas;
use App\Filament\Resources\ParamAulas\Pages\ViewParamAula;
use App\Filament\Resources\ParamAulas\Schemas\ParamAulaForm;
use App\Filament\Resources\ParamAulas\Schemas\ParamAulaInfolist;
use App\Filament\Resources\ParamAulas\Tables\ParamAulasTable;
use App\Models\ParamAula;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class ParamAulaResource extends Resource
{
    protected static ?string $model = ParamAula::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'codigo_aula';

    public static function form(Schema $schema): Schema
    {
        return ParamAulaForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return ParamAulaInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ParamAulasTable::configure($table);
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
            'index' => ListParamAulas::route('/'),
            'create' => CreateParamAula::route('/create'),
            'view' => ViewParamAula::route('/{record}'),
            'edit' => EditParamAula::route('/{record}/edit'),
        ];
    }
}
