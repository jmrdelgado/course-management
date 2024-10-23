<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProgrammingResource\Pages;
use App\Filament\Resources\ProgrammingResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Support\Enums\Alignment;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Forms\Components\Section;
use Filament\Forms\Set;
use Filament\Forms\Get;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

use App\Models\Action;
use App\Models\Programming;

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
                Section::make('Acción Formativa')
                ->schema([
                    Forms\Components\Select::make('action_id')
                        ->label('Denominación')
                        ->relationship('action', 'denomination')
                        ->preload()
                        ->live()
                        ->afterStateUpdated(function (Set $set, Get $get) {
                            $action = Action::findOrfail($get('action_id'));                 
                            $set('naction', $action->naction);
                            if ($action->naction == '0000') {
                                $set('ngroup', '0000');
                            }
                            $set('nhours', $action->nhours);
                        })
                        ->searchable()
                        ->required()
                ])
                ->compact(),
                Section::make('Datos identificativos')
                ->schema([
                    Forms\Components\TextInput::make('naction')
                        ->label('Nº Acción')
                        ->numeric()
                        ->required()
                        ->readonly(),
                    Forms\Components\TextInput::make('ngroup')
                        ->label('Nº Grupo')
                        ->maxLength(6)
                        ->numeric()
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
                        ->numeric()
                        ->readonly(),
                    Forms\Components\TextInput::make('number_students')
                        ->label('Nº Alumnos')
                        ->required()
                        ->numeric(),
                    Forms\Components\Select::make('course_type')
                        ->label('Tipo Curso')
                        ->options([
                            'Bonificado' => 'Bonificado',
                            'Gestionado' => 'Gestionado',
                            'Impartido' => 'Impartido',
                            'Privado' => 'Privado'
                        ])
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
                    Forms\Components\Select::make('company_id')
                        ->label('Empresa')
                        ->relationship('company', 'company')
                        ->preload()
                        ->searchable()
                        ->required(),
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
                    Forms\Components\Select::make('billed_month')
                        ->label('Facturado')
                        ->options(
                            [
                                'Enero' => 'Enero',
                                'Febrero' => 'Febrero',
                                'Marzo' => 'Marzo',
                                'Abril' => 'Abril',
                                'Mayo' => 'Mayo',
                                'Junio' => 'Junio',
                                'Julio' => 'Julio',
                                'Agosto' => 'Agosto',
                                'Septiembre' => 'Septiembre',
                                'Octubre' => 'Octubre',
                                'Noviembre' => 'Noviembre',
                                'Diciembre' => 'Diciembre'    
                            ]
                        ),
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
                    ->label('Acción')
                    ->size(TextColumn\TextColumnSize::ExtraSmall)
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('ngroup')
                    ->label('Grupo')
                    ->size(TextColumn\TextColumnSize::ExtraSmall)
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('action.denomination')
                    ->label('Denominación')
                    ->size(TextColumn\TextColumnSize::ExtraSmall)
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('modality')
                    ->label('Modalidad')
                    ->size(TextColumn\TextColumnSize::ExtraSmall)
                    ->alignment(Alignment::Center)
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('platform.name')
                    ->label('Plataforma')
                    ->size(TextColumn\TextColumnSize::ExtraSmall)
                    ->alignment(Alignment::Center)
                    ->searchable()
                    ->sortable()
                    ->badge()
                    ->color(fn (string $state): string => match($state) {
                        'CAE' => 'celeste',
                        'CAE IDIOMAS' => 'azul',
                        'VÉRTICE' => 'rojo_claro',
                    }),
                Tables\Columns\TextColumn::make('nhours')
                    ->label('Horas')
                    ->size(TextColumn\TextColumnSize::ExtraSmall)
                    ->alignment(Alignment::Center)
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('communication_date')
                    ->label('Comunicación')
                    ->size(TextColumn\TextColumnSize::ExtraSmall)
                    ->date()
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('start_date')
                    ->label('F.Inicio')
                    ->size(TextColumn\TextColumnSize::ExtraSmall)
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('end_date')
                    ->label('F.Fin')
                    ->size(TextColumn\TextColumnSize::ExtraSmall)
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('number_students')
                    ->label('Alumnos')
                    ->size(TextColumn\TextColumnSize::ExtraSmall)
                    ->alignment(Alignment::Center)
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('company.company')
                    ->label('Empresa')
                    ->size(TextColumn\TextColumnSize::ExtraSmall)
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('tutor.name')
                    ->label('Tutor')
                    ->size(TextColumn\TextColumnSize::ExtraSmall)
                    ->numeric()
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('coordinator.name')
                    ->label('Coordinador')
                    ->size(TextColumn\TextColumnSize::ExtraSmall)
                    ->alignment(Alignment::Center)
                    ->numeric()
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('agent.name')
                    ->label('Comercial')
                    ->size(TextColumn\TextColumnSize::ExtraSmall)
                    ->alignment(Alignment::Center)
                    ->numeric()
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('supplier.name')
                    ->label('Proveedor')
                    ->size(TextColumn\TextColumnSize::ExtraSmall)
                    ->alignment(Alignment::Center)
                    ->numeric()
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('course_type')
                    ->label('Tipo')
                    ->size(TextColumn\TextColumnSize::ExtraSmall),
                Tables\Columns\TextColumn::make('cost')
                    ->label('Coste')
                    ->size(TextColumn\TextColumnSize::ExtraSmall)
                    ->money('EUR')
                    ->sortable(),
                Tables\Columns\TextColumn::make('billed_month')
                    ->label('Facturado')
                    ->size(TextColumn\TextColumnSize::ExtraSmall)
                    ->searchable(),
                Tables\Columns\ToggleColumn::make('rlt')
                    ->label('RLT'),
                Tables\Columns\ToggleColumn::make('rlt_send')
                    ->label('RLT Enviada')
                    ->alignment(Alignment::Center),
                Tables\Columns\ToggleColumn::make('rlt_received')
                    ->label('RLT Recibida')
                    ->alignment(Alignment::Center),
                Tables\Columns\ToggleColumn::make('rlt_faborable')
                    ->label('RLT Faborable')
                    ->alignment(Alignment::Center),
                Tables\Columns\ToggleColumn::make('rlt_incident')
                    ->label('RLT Desfaborable')
                    ->alignment(Alignment::Center),
                Tables\Columns\IconColumn::make('incident')
                    ->label('Incidentado')
                    ->alignment(Alignment::Center)
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
            ])
            ->recordClasses(
                /* fn (Programming $record) => $record->canceled == 1 ? 'my-line-bg-canceled' : null */
                fn (Programming $record) => $record->incident == 1 ? 'my-line-bg-incident' : null
            );
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
