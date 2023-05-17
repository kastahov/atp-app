<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ShipmentResource\Pages;
use App\Models\Delivery;
use App\Models\User;
use Cheesegrits\FilamentGoogleMaps\Fields\Geocomplete;
use Filament\Forms;
use Filament\Tables\Actions\Action;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
use Webbingbrasil\FilamentDateFilter\DateFilter;

class DeliveryResource extends Resource
{
    protected static ?string $model = Delivery::class;

    protected static ?string $navigationIcon = 'heroicon-o-truck';

    public static function getLabel(): ?string
    {
        return __('deliveries.resource_label');
    }

    public static function getPluralLabel(): ?string
    {
        return __('deliveries.resource_plural_label');
    }

    public static function getEloquentQuery(): Builder
    {
        $user = auth()->user();

        $query = parent::getEloquentQuery()->orderByDesc('created_at');

        if ($user->role === 'driver') {
            return $query->where('driver_id', $user->id);
        }

        return $query;
    }

    public static function form(Form $form): Form
    {
        return $form
            ->columns(1)
            ->schema([
                Forms\Components\Select::make('dispatcher_id')
                    ->label(__('profile.dispatcher'))
                    ->relationship('dispatcher', 'full_name')
                    ->searchable()
                    ->getSearchResultsUsing(
                        fn(string $search) => User::where('full_name', 'like', "%{$search}%")
                            ->where('role', '=', 'dispatcher')
                            ->limit(50)
                            ->pluck('full_name', 'id')
                    ),
                Forms\Components\Select::make('driver_id')
                    ->label(__('profile.driver'))
                    ->relationship('driver', 'full_name')
                    ->searchable()
                    ->getSearchResultsUsing(
                        fn(string $search) => User::where('full_name', 'like', "%{$search}%")
                            ->where('role', '=', 'driver')
                            ->has('vehicle')
                            ->doesntHave('driverDelivery')
                            ->limit(50)
                            ->pluck('full_name', 'id')
                    ),
                Forms\Components\TextInput::make('sender')
                    ->label(__('deliveries.sender'))
                    ->required()
                    ->minLength(3),
                Forms\Components\TextInput::make('receiver')
                    ->label(__('deliveries.receiver'))
                    ->required()
                    ->minLength(3),
                Geocomplete::make('loading_location')
                    ->label(__('deliveries.loading_location'))
                    ->placeholder('Введіть назву локації')
                    ->required(),
                Geocomplete::make('destination')
                    ->label(__('deliveries.destination'))
                    ->placeholder('Введіть назву локації')
                    ->required(),
                Forms\Components\DateTimePicker::make('arrival_time')
                    ->label(__('deliveries.arrival_time'))
                    ->required(),
                Forms\Components\KeyValue::make('cargo')
                    ->label(__('deliveries.cargo'))
                    ->default([
                        'name' => '',
                        'quantity' => '',
                        'weight' => '',
                        'size' => '',
                    ])
                    ->disableEditingKeys()
                    ->disableDeletingRows()
                    ->disableAddingRows()
                    ->required(),
                Forms\Components\Select::make('status')
                    ->label(__('deliveries.status'))
                    ->options([
                        'scheduled' => __('delivery_statuses.scheduled'),
                        'waits_to_load' => __('delivery_statuses.waits_to_load'),
                        'in_progress' => __('delivery_statuses.in_progress'),
                        'shipped' => __('delivery_statuses.shipped'),
                        'awaiting_unloading' => __('delivery_statuses.awaiting_unloading'),
                        'finished' => __('delivery_statuses.finished'),
                    ])
                    ->default('scheduled')
                    ->required(),
                Forms\Components\Textarea::make('comment')
                    ->label('Додаткова інформація')
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('driver.full_name')
                    ->label(__('profile.driver')),
                Tables\Columns\TextColumn::make('dispatcher.full_name')
                    ->label(__('profile.dispatcher')),
                Tables\Columns\TextColumn::make('sender')
                    ->label(__('deliveries.sender'))
                    ->searchable(),
                Tables\Columns\TextColumn::make('driver.vehicle.brand')
                    ->label(__('vehicles.vehicle'))
                    ->searchable(),
                Tables\Columns\TextColumn::make('receiver')
                    ->label(__('deliveries.receiver'))
                    ->searchable(),
                Tables\Columns\TextColumn::make('loading_location')
                    ->label(__('deliveries.loading_location'))
                    ->searchable(),
                Tables\Columns\TextColumn::make('destination')
                    ->label(__('deliveries.destination'))
                    ->searchable(),
                Tables\Columns\BadgeColumn::make('status')
                    ->label(__('deliveries.status'))
                    ->enum([
                        'scheduled' => __('delivery_statuses.scheduled'),
                        'waits_to_load' => __('delivery_statuses.waits_to_load'),
                        'in_progress' => __('delivery_statuses.in_progress'),
                        'shipped' => __('delivery_statuses.shipped'),
                        'awaiting_unloading' => __('delivery_statuses.awaiting_unloading'),
                        'finished' => __('delivery_statuses.finished'),
                    ])
                    ->color(static function ($state): string {
                        return match ($state) {
                            'scheduled' => 'primary',
                            'in_progress' => 'secondary',
                            'waits_to_load', 'awaiting_unloading' => 'warning',
                            'shipped', 'finished' => 'success',
                        };
                    }),
                Tables\Columns\TextColumn::make('arrival_time')
                    ->label(__('deliveries.arrival_time')),
                Tables\Columns\TextColumn::make('cargo')
                    ->label(__('deliveries.cargo'))
                    ->searchable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label(__('dates.created_at')),
                Tables\Columns\TextColumn::make('updated_at')
                    ->label(__('dates.updated_at')),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->label(__('deliveries.status'))
                    ->multiple()
                    ->options([
                        'scheduled' => __('delivery_statuses.scheduled'),
                        'waits_to_load' => __('delivery_statuses.waits_to_load'),
                        'in_progress' => __('delivery_statuses.in_progress'),
                        'shipped' => __('delivery_statuses.shipped'),
                        'awaiting_unloading' => __('delivery_statuses.awaiting_unloading'),
                        'finished' => __('delivery_statuses.finished'),
                    ]),
                DateFilter::make('created_at')
                    ->label(__('dates.created_at_filter'))
                    ->range()
                    ->fromLabel(__('З'))
                    ->untilLabel(__('По')),
                SelectFilter::make('driver_id')
                    ->label(__('profile.driver'))
                    ->relationship('driver', 'full_name')
                    ->searchable(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Action::make('Завантажити')
                    ->icon('heroicon-o-document-download')
                    ->url(fn (Delivery $record) => route('deliveries.download-pdf', $record))
                    ->openUrlInNewTab()
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
            'index' => Pages\ListDeliveries::route('/'),
            'create' => Pages\CreateDelivery::route('/create'),
            'edit' => Pages\EditDelivery::route('/{record}/edit'),
        ];
    }
}
