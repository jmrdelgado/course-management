<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProgrammingResource\Pages;
use App\Filament\Resources\ProgrammingResource\RelationManagers;
use App\Models\Programming;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Components\Section;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ProgrammingResource extends Resource
{
    protected static ?string $model = Programming::class;

    protected static ?string $modelLabel = 'Cursos';
    protected static ?string $navigationIcon = 'heroicon-s-rectangle-group';
    protected static ?string $navigationGroup = 'Programación de Cursos';
    protected static ?int $navigationSort = 10;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Datos identificativos')
                ->schema([
                    Forms\Components\TextInput::make('naction')
                        ->label('Nº Acción')
                        ->required()
                        ->readonly()
                        ->numeric(),
                    Forms\Components\TextInput::make('ngroup')
                        ->label('Nº Grupo')
                        ->required()
                        ->numeric(),
                    Forms\Components\Select::make('action_id')
                        ->label('Denominación')
                        ->relationship('action', 'denomination')
                        ->preload()
                        ->searchable()
                        ->required(),
                    Forms\Components\TextInput::make('modality')
                        ->label('Modalidad')
                        ->required()
                        ->maxLength(255)
                        ->default('TF')
                        ->readonly(),
                    Forms\Components\Select::make('platform_id')
                        ->label('Plataforma')
                        ->relationship('platform', 'name')
                        ->preload()
                        ->required(),
                    Forms\Components\TextInput::make('nhours')
                        ->label('Nº Horas')
                        ->required()
                        ->numeric(),
                    Forms\Components\TextInput::make('number_students')
                        ->label('Nº Alumnos')
                        ->required()
                        ->numeric(),
                    Forms\Components\TextInput::make('course_type')
                        ->label('Tipo Curso')
                        ->required(),
                    Forms\Components\Select::make('supplier_id')
                        ->label('Proveedor')
                        ->relationship('supplier', 'name')
                        ->preload()
                        ->required(),
                    Forms\Components\Select::make('tutor_id')
                        ->label('Tutor')
                        ->relationship('tutor', 'name')
                        ->preload()
                        ->required(),
                    Forms\Components\Select::make('coordinator_id')
                        ->label('Coordinador')
                        ->relationship('coordinator', 'name')
                        ->preload()
                        ->required(),
                    Forms\Components\Select::make('agent_id')
                        ->label('Agente')
                        ->relationship('agent', 'name')
                        ->preload()
                        ->required(),
                ])
                ->compact()
                ->columns(3),

                Section::make('Datos de comunicación')
                ->schema([
                    Forms\Components\DatePicker::make('communication_date')
                        ->label('F. Comunicación'),
                    Forms\Components\DatePicker::make('start_date')
                        ->label('F. Inicio')
                        ->required(),
                    Forms\Components\DatePicker::make('end_date')
                        ->label('F.Fin')
                        ->required(),
                ])
                ->compact()
                ->columns(3),

                Section::make('Datos de la empresa')
                ->schema([
                    Forms\Components\TextInput::make('company_id')
                        ->label('Empresa')
                        ->required()
                        ->numeric(),
                ])
                ->compact()
                ->columns(2),
                
                Section::make('Datos económicos')
                ->schema([
                    Forms\Components\TextInput::make('cost')
                        ->label('Coste')
                        ->required()
                        ->numeric()
                        ->prefix('€'),
                    Forms\Components\TextInput::make('billed_month')
                        ->label('Facturado')
                        ->required(),
                ])
                ->compact()
                ->columns(2),

                Section::make('Datos de la RLT')
                ->schema([
                    Forms\Components\Toggle::make('rlt')
                        ->label('RLT')
                        ->required(),
                    Forms\Components\Toggle::make('rlt_send')
                        ->label('RLT Enviada')
                        ->required(),
                    Forms\Components\Toggle::make('rlt_received')
                        ->label('RLT Recibida')
                        ->required(),
                    Forms\Components\Toggle::make('rlt_faborable')
                        ->label('RLT Favorable')
                        ->required(),
                    Forms\Components\Toggle::make('rlt_incident')
                        ->label('RLT Incidentada')
                        ->required(),
                ])
                ->compact()
                ->columns(5),

                Section::make('')
                ->schema([
                    Forms\Components\Textarea::make('observations')
                        ->label('Observaciones')
                        ->columnSpanFull(),
                    Forms\Components\Toggle::make('canceled')
                        ->label('Anulado')
                        ->required(),
                    Forms\Components\Toggle::make('incident')
                        ->label('Incidentado')
                        ->required(),
                ])
                ->compact()
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('naction')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('ngroup')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('action_id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('modality')
                    ->searchable(),
                Tables\Columns\TextColumn::make('platform_id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('nhours')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('communication_date')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('start_date')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('end_date')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('number_students')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('company_id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('tutor_id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('coordinator_id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('agent_id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('supplier_id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('course_type'),
                Tables\Columns\TextColumn::make('cost')
                    ->money()
                    ->sortable(),
                Tables\Columns\TextColumn::make('billed_month'),
                Tables\Columns\IconColumn::make('rlt')
                    ->boolean(),
                Tables\Columns\IconColumn::make('rlt_send')
                    ->boolean(),
                Tables\Columns\IconColumn::make('rlt_received')
                    ->boolean(),
                Tables\Columns\IconColumn::make('rlt_faborable')
                    ->boolean(),
                Tables\Columns\IconColumn::make('rlt_incident')
                    ->boolean(),
                Tables\Columns\IconColumn::make('canceled')
                    ->boolean(),
                Tables\Columns\IconColumn::make('incident')
                    ->boolean(),
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
            'index' => Pages\ListProgrammings::route('/'),
            'create' => Pages\CreateProgramming::route('/create'),
            'edit' => Pages\EditProgramming::route('/{record}/edit'),
        ];
    }
}
