<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CompanyResource\Pages;
use App\Filament\Resources\CompanyResource\RelationManagers;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Components\Select;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Set;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

use App\Models\Company;
use App\Models\GroupCompany;

use Illuminate\Support\Str;

class CompanyResource extends Resource
{
    protected static ?string $model = Company::class;

    protected static ?string $modelLabel = 'Empresas';
    protected static ?string $navigationIcon = 'heroicon-s-building-office';
    protected static ?int $navigationSort = 3;
    protected static ?string $navigationGroup = 'Gestión de Empresas';

    //Obtenemos todas de registros existentes
    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('company')
                    ->label('Nombre de Empresa')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Select::make('groupcompany_id')
                    ->label('Grupo Empresarial')
                    ->relationship('groupcompany', 'name')
                    ->preload()
                    ->live()
                    ->createOptionForm([
                        Forms\Components\TextInput::make('name')
                            ->label('Nuevo Grupo Empresarial')
                            ->required(),
                    ])
                    ->createOptionUsing(function (array $data): int {
                        $newgroupcompany = GroupCompany::create([
                            'name' => $data['name'] = Str::upper($data['name'])
                        ]);

                        return $newgroupcompany->id;
                        
                    })
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('company')
                    ->label('Nombre de Empresa')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('groupcompany.name')
                    ->label('Grupo empresarial')
                    ->numeric()
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
            'index' => Pages\ListCompanies::route('/'),
            'create' => Pages\CreateCompany::route('/create'),
            'edit' => Pages\EditCompany::route('/{record}/edit'),
        ];
    }
}
