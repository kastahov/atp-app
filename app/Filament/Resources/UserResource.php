<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Models\User;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-group';

    public static function getLabel(): ?string
    {
        return __('users.resource_label');
    }

    public static function getPluralLabel(): ?string
    {
        return __('users.resource_plural_label');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->columns(1)
            ->schema([
                Forms\Components\TextInput::make('first_name')
                    ->label(__('profile.first_name'))
                    ->minLength(3)
                    ->required(),
                Forms\Components\TextInput::make('middle_name')
                    ->label(__('profile.middle_name'))
                    ->minLength(3),
                Forms\Components\TextInput::make('last_name')
                    ->label(__('profile.last_name'))
                    ->minLength(3)
                    ->required(),
                Forms\Components\TextInput::make('email')
                    ->email()
                    ->required(),
                Forms\Components\Select::make('role')
                    ->label(__('profile.role'))
                    ->options([
                        'dispatcher' => __('profile.dispatcher'),
                        'driver' => __('profile.driver'),
                    ])
                    ->required(),
                Forms\Components\TextInput::make('password')
                    ->label(__('profile.password'))
                    ->password()
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id'),
                Tables\Columns\TextColumn::make('role')
                    ->label(__('profile.role'))
                    ->enum([
                        'dispatcher' => __('profile.dispatcher'),
                        'driver' => __('profile.driver'),
                    ]),
                Tables\Columns\TextColumn::make('full_name')
                    ->label(__('profile.full_name'))
                    ->searchable(),
                Tables\Columns\TextColumn::make('email')
                    ->searchable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
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
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}
