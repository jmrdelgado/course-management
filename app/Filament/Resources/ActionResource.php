<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ActionResource\Pages;
use App\Filament\Resources\ActionResource\RelationManagers;
use App\Models\Action;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ActionResource extends Resource
{
    protected static ?string $model = Action::class;
    protected static ?string $modelLabel = 'Acciones';
    protected static ?string $navigationIcon = 'heroicon-s-book-open';
    protected static ?int $navigationSort = 6;
    protected static ?string $navigationGroup = 'Gestión de Formación';

    //Contador de Acciones existentes
    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('naction')
                    ->label('Nº Acción')
                    ->required()
                    ->mask('999999')
                    ->maxLength(6),
                Forms\Components\TextInput::make('denomination')
                    ->label('Denominación')
                    ->required(),
                Forms\Components\TextInput::make('nhours')
                    ->label('Nº Horas')
                    ->required()
                    ->mask('999999')
                    ->maxLength(6),
            ])
            ->columns(3);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('naction')
                    ->label('Nº Acción')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('denomination')
                    ->label('Denominación')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('nhours')
                    ->label('Nº Horas'),
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
            'index' => Pages\ListActions::route('/'),
            'create' => Pages\CreateAction::route('/create'),
            'edit' => Pages\EditAction::route('/{record}/edit'),
        ];
    }
}
