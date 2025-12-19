<?php

namespace App\Filament\Resources\UserRols\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use App\Models\User;
use App\Models\ParamRol;
use Filament\Tables;

class UserRolsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                // TextColumn::make('id_user')
                //     ->numeric()
                //     ->sortable(),
                // TextColumn::make('id_rol')
                //     ->numeric()
                //     ->sortable(),
                TextColumn::make('id_user')
                    ->label('Usuario')
                    ->formatStateUsing(fn($state) => User::find($state)?->name ?? '-')
                    ->searchable(),
                TextColumn::make('id_rol')
                    ->label('Rol')
                    ->formatStateUsing(fn($state) => ParamRol::find($state)?->rol ?? '-')
                    ->searchable(),
                TextColumn::make('estado')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
