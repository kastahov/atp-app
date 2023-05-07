<?php

namespace App\Filament\Resources;

use App\Filament\Resources\VehicleResource\Pages;
use App\Models\User;
use App\Models\Vehicle;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;

class VehicleResource extends Resource
{
    protected static ?string $model = Vehicle::class;

    protected static ?string $navigationIcon = 'heroicon-o-cog';

    public static function getLabel(): ?string
    {
        return __('vehicles.resource_label');
    }

    public static function getPluralLabel(): ?string
    {
        return __('vehicles.resource_plural_label');
    }

    public static function getEloquentQuery(): Builder
    {
        $user = auth()->user();

        if ($user->role === 'driver') {
            return parent::getEloquentQuery()->where('driver_id', $user->id);
        }

        return parent::getEloquentQuery();
    }

    public static function form(Form $form): Form
    {
        return $form
            ->columns(1)
            ->schema([
                Forms\Components\Select::make('driver_id')
                    ->label(__('profile.driver'))
                    ->relationship('driver', 'full_name')
                    ->searchable()
                    ->getSearchResultsUsing(
                        fn (string $search) => User::where('full_name', 'like', "%{$search}%")
                            ->where('role', '=', 'driver')
                            ->limit(50)
                            ->pluck('full_name', 'id')
                    ),
                Forms\Components\TextInput::make('brand')
                    ->label(__('vehicles.brand'))
                    ->required(),
                Forms\Components\TextInput::make('model')
                    ->label(__('vehicles.model'))
                    ->required(),
                Forms\Components\TextInput::make('reg_number')
                    ->label(__('vehicles.reg_number'))
                    ->required(),
                Forms\Components\Select::make('status')
                    ->label(__('vehicles.status'))
                    ->required()
                    ->options([
                        'works' => __('vehicle_statuses.works'),
                        'broken' => __('vehicle_statuses.broken'),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('driver.full_name')
                    ->label(__('profile.driver'))
                    ->searchable(),
                Tables\Columns\TextColumn::make('brand')
                    ->label(__('vehicles.brand'))
                    ->searchable(),
                Tables\Columns\TextColumn::make('model')
                    ->label(__('vehicles.model'))
                    ->searchable(),
                Tables\Columns\TextColumn::make('reg_number')
                    ->label(__('vehicles.reg_number'))
                    ->searchable(),
                Tables\Columns\BadgeColumn::make('status')
                    ->label(__('vehicles.status'))
                    ->enum([
                        'works' => __('vehicle_statuses.works'),
                        'broken' => __('vehicle_statuses.broken'),
                    ])
                    ->color(static function ($state): string {
                        return match ($state) {
                            'works' => 'success',
                            'broken' => 'warning',
                        };
                    }),
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
            'index' => Pages\ListVehicles::route('/'),
            'create' => Pages\CreateVehicle::route('/create'),
            'edit' => Pages\EditVehicle::route('/{record}/edit'),
        ];
    }
}
