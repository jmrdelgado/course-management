<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Action;
use Filament\Forms\Get;
use Filament\Forms\Set;
use App\Models\Supplier;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Illuminate\Support\Str;
use Filament\Resources\Resource;
use Illuminate\Support\Facades\Auth;
use Filament\Support\Enums\Alignment;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\ActionResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\ActionResource\RelationManagers;

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
        if (Auth::user()->hasRole('panel_user')) {
            return parent::getEloquentQuery()->where('modality', 'tf')->count();
        } elseif (Auth::user()->hasRole('panel_user_presencial')) {
            return parent::getEloquentQuery()->where('modality', 'P')->orWhere('modality','M')->orWhere('modality','AV')->count();
        } else {
            return static::getModel()::count();
        }
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
                Forms\Components\Select::make('modality')
                    ->label('Modalidad')
                    ->required()
                    ->options(
                        [
                            'P' => 'P',
                            'M' => 'M',
                            'AV' => 'AV',
                            'TF' => 'TF'
                        ]
                    ),
                Forms\Components\TextInput::make('cod_fundae')
                    ->label('Cód. Fundae')
                    ->mask('99999999')
                    ->default(0)
                    ->maxLength(8),
                Forms\Components\TextInput::make('nhoursp')
                    ->label('Horas Presenciales')
                    ->required()
                    ->mask('999999')
                    ->default(0)
                    ->maxLength(6)
                    ->live(onBlur: true)
                    ->afterStateUpdated(function (Set $set, Get $get) {
                        $hp = $get('nhoursp');
                        $htf = $get('nhourstf');
                        $ht = $hp + $htf;
                        $set('nhourst', $ht);
                    }),
                Forms\Components\TextInput::make('nhourstf')
                    ->label('Horas Teleformación')
                    ->required()
                    ->mask('999999')
                    ->default(0)
                    ->maxLength(6)
                    ->live(onBlur: true)
                    ->afterStateUpdated(function (Set $set, Get $get) {
                        $hp = $get('nhoursp');
                        $htf = $get('nhourstf');
                        $ht = $hp + $htf;
                        $set('nhourst', $ht);
                    }),
                Forms\Components\TextInput::make('nhourst')
                    ->label('Horas Totales')
                    ->required()
                    ->mask('999999')
                    ->maxLength(6)
                    ->default(0)
                    ->disabled()
                    ->dehydrated(true),
                Forms\Components\Select::make('supplier_id')
                    ->label('Proveedor')
                    ->relationship('supplier', 'name')
                    ->preload()
                    ->required()
                    ->optionsLimit(10)
                    ->live()
                    ->createOptionForm([
                        Forms\Components\TextInput::make('name')
                        ->label('Proveedor')
                        ->required()
                    ])
                    ->createOptionUsing(function (array $data): int {
                        $newsupplier = Supplier::create([
                            'name' => $data['name'] = Str::upper($data['name']),
                        ]);

                        return $newsupplier->id;
                    }),
            ])
            ->columns(4);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('naction')
                    ->label('Nº Acción')
                    ->size(TextColumn\TextColumnSize::ExtraSmall)
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('cod_fundae')
                    ->label('Cód. Fundae')
                    ->size(TextColumn\TextColumnSize::ExtraSmall)
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('denomination')
                    ->label('Denominación')
                    ->size(TextColumn\TextColumnSize::ExtraSmall)
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('modality')
                    ->label('Modalidad')
                    ->size(TextColumn\TextColumnSize::ExtraSmall)
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('nhourst')
                    ->label('Horas Totales')
                    ->size(TextColumn\TextColumnSize::ExtraSmall),
                Tables\Columns\TextColumn::make('supplier.name')
                    ->label('Proveedor')
                    ->size(TextColumn\TextColumnSize::ExtraSmall)
                    ->alignment(Alignment::Center)
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            //Mostramos registros correspondientes al técnico conectado
            ->modifyQueryUsing(function (Builder $query) {
                if (Auth::user()->hasRole('panel_user')) {
                    return $query->where('modality', 'TF');
                } elseif (Auth::user()->hasRole('panel_user_presencial')) {
                    return $query->where('modality', '=','P')->Orwhere('modality', '=', 'M')->Orwhere('modality', '=', 'AV');
                }
            })
            ->filters([
                SelectFilter::make('modality')
                    ->options(
                        [
                            'P' => 'P',
                            'M' => 'M',
                            'AV' => 'AV',
                            'TF' => 'TF'
                        ]
                    )
                    ->label('Modalidad'),
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
