<?php

namespace App\Filament\Resources\UserRols;

use App\Filament\Resources\UserRols\Pages\CreateUserRol;
use App\Filament\Resources\UserRols\Pages\EditUserRol;
use App\Filament\Resources\UserRols\Pages\ListUserRols;
use App\Filament\Resources\UserRols\Pages\ViewUserRol;
use App\Filament\Resources\UserRols\Schemas\UserRolForm;
use App\Filament\Resources\UserRols\Schemas\UserRolInfolist;
use App\Filament\Resources\UserRols\Tables\UserRolsTable;
use App\Models\UserRol;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class UserRolResource extends Resource
{
    protected static ?string $model = UserRol::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'UserRol';

    public static function form(Schema $schema): Schema
    {
        return UserRolForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return UserRolInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return UserRolsTable::configure($table);
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
            'index' => ListUserRols::route('/'),
            'create' => CreateUserRol::route('/create'),
            'view' => ViewUserRol::route('/{record}'),
            'edit' => EditUserRol::route('/{record}/edit'),
        ];
    }
}
