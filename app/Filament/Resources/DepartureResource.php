<?php

namespace App\Filament\Resources;

use App\Filament\Resources\DepartureResource\Pages;
use App\Filament\Resources\DepartureResource\RelationManagers;
use App\Models\Departure;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class DepartureResource extends Resource
{
    protected static ?string $model = Departure::class;

    protected static ?string $modelLabel = 'Salidas';
    protected static ?string $navigationIcon = 'heroicon-s-calendar-date-range';
    protected static ?string $navigationGroup = 'Programación';
    protected static ?int $navigationSort = 10;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('title')
                    ->label('Tipo Evento')
                    ->required()
                    ->maxLength(255),
                Forms\Components\ColorPicker::make('color')
                    ->label('Color identificativo'),
                Forms\Components\DatePicker::make('start_at')
                    ->label('Fecha Inicio')
                    ->required(),
                Forms\Components\DatePicker::make('end_at')
                    ->label('Fecha Fin')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            /* ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->label('Tipo Evento')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('start_at')
                    ->date('d-m-Y')
                    ->label('Fecha Inicio')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('end_at')
                    ->date('d-m-Y')
                    ->label('Fecha Fin')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]); */
            ->paginated(false);
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
            'index' => Pages\ListDepartures::route('/'),
            'create' => Pages\CreateDeparture::route('/create'),
            'edit' => Pages\EditDeparture::route('/{record}/edit'),
        ];
    }
}
