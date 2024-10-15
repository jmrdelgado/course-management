<?php

namespace App\Filament\Resources;

use App\Filament\Resources\GroupCompanyResource\Pages;
use App\Filament\Resources\GroupCompanyResource\RelationManagers;
use App\Models\GroupCompany;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class GroupCompanyResource extends Resource
{
    protected static ?string $model = GroupCompany::class;

    protected static ?string $navigationLabel = 'Grupo de Empresas';
    protected static ?string $navigationIcon = 'heroicon-s-building-office-2';
    protected static ?int $navigationSort = 4;
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
                    ->label('Grupo Empresarial')
                    ->required()
                    ->maxLength(255),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Grupo Empresarial')
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
            'index' => Pages\ListGroupCompanies::route('/'),
            'create' => Pages\CreateGroupCompany::route('/create'),
            'edit' => Pages\EditGroupCompany::route('/{record}/edit'),
        ];
    }
}
