<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CoordinatorResource\Pages;
use App\Filament\Resources\CoordinatorResource\RelationManagers;
use App\Models\Coordinator;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class CoordinatorResource extends Resource
{
    protected static ?string $model = Coordinator::class;

    protected static ?string $modelLabel = 'Coordinadores';
    protected static ?string $navigationIcon = 'heroicon-s-identification';
    protected static ?int $navigationSort = 9;
    protected static ?string $navigationGroup = 'Gestión de Formación';

    //Obtenemos todas de registros existentes
    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->label('Nombre')
                    ->required()
                    ->maxLength(255),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Nombre')
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
            'index' => Pages\ListCoordinators::route('/'),
            'create' => Pages\CreateCoordinator::route('/create'),
            'edit' => Pages\EditCoordinator::route('/{record}/edit'),
        ];
    }
}
