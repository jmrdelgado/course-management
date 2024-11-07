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
use Filament\Tables\Columns\ColorColumn;
use Filament\Support\Enums\Alignment;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Forms\Components\Section;
use Filament\Tables\Filters\Filter;
use Filament\Forms\Components\DatePicker;
use Filament\Tables\Filters\SelectFilter;
use Filament\Forms\Set;
use Filament\Forms\Get;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Str;
use Carbon\Carbon;

use App\Models\Action;
use App\Models\Programming;
use App\Models\Company;
use App\Models\GroupCompany;
use App\Models\Tutor;
use App\Models\Supplier;
use App\Models\Departure;

class ProgrammingResource extends Resource
{
    protected static ?string $model = Programming::class;

    protected static ?string $modelLabel = 'Cursos';
    protected static ?string $navigationIcon = 'heroicon-s-rectangle-group';
    protected static ?string $navigationGroup = 'Programación';
    protected static ?int $navigationSort = 11;

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
                        ->createOptionForm([
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
                        ->createOptionUsing(function (array $data): int {
                            $newaction = Action::create([
                                'naction' => $data['naction'],
                                'denomination' => $data['denomination'] = Str::upper($data['denomination']),
                                'nhours' => $data['nhours']
                            ]);

                            return $newaction->id;
                        })
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
                        ->optionsLimit(5)
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
                        ->required()
                        ->optionsLimit(5),
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
                        ->required()
                        ->optionsLimit(5),
                    Forms\Components\Select::make('supplier_id')
                        ->label('Proveedor')
                        ->relationship('supplier', 'name')
                        ->preload()
                        ->required()
                        ->optionsLimit(5)
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
                    Forms\Components\Select::make('tutor_id')
                        ->label('Tutor')
                        ->relationship('tutor', 'name')
                        ->preload()
                        ->required()
                        ->optionsLimit(5)
                        ->live()
                        ->createOptionForm([
                            Forms\Components\TextInput::make('name')
                            ->label('Nombre Tutor')
                            ->required()
                        ])
                        ->createOptionUsing(function (array $data): int {
                            $newtutor = Tutor::create([
                                'name' => $data['name'] = Str::upper($data['name']),
                            ]);
    
                            return $newtutor->id;
                        }),
                    Forms\Components\Select::make('coordinator_id')
                        ->label('Coordinador')
                        ->relationship('coordinator', 'name')
                        ->preload()
                        ->required()
                        ->optionsLimit(5)
                        ->live()
                        ->createOptionForm([
                            Forms\Components\TextInput::make('name')
                            ->label('Nombre Coordinador')
                            ->required()
                        ])
                        ->createOptionUsing(function (array $data): int {
                            $newcoordinator = Coordinator::create([
                                'name' => $data['name'] = Str::upper($data['name']),
                            ]);

                            return $newcoordinator->id;
                        }),
                    Forms\Components\Select::make('agent_id')
                        ->label('Agente')
                        ->relationship('agent', 'name')
                        ->preload()
                        ->required()
                        ->optionsLimit(5),
                ])
                ->compact()
                ->columns(3),

                Section::make('Datos de comunicación')
                ->schema([
                    Forms\Components\DatePicker::make('communication_date')
                        ->label('F.Comunicación'),
                    Forms\Components\Select::make('departure_id')
                        ->label('F.Salida')
                        ->relationship('departure', 'departure_date', function ($query) {
                            $datos = $query->selectRaw("id, DATE_FORMAT(departure_date, '%d-%m-%Y') as departure_date");
                            return $datos;
                            })
                        ->preload()
                        ->live()
                        ->required()
                        ->createOptionForm([
                            DatePicker::make('departure_date')
                            ->label('Fecha Salida')
                            ->required()
                        ])
                        ->afterStateUpdated(function (Set $set, Get $get) {
                            $newdate = Departure::findOrfail($get('departure_id'));
                            $set('start_date', $newdate->departure_date);
                        }),
                    Forms\Components\TextInput::make('start_date')
                        ->label('F.Inicio')
                        ->disabled()
                        ->dehydrated(true),
                    Forms\Components\DatePicker::make('end_date')
                        ->label('F.Fin')
                        ->required(),
                ])
                ->compact()
                ->columns(4),

                Section::make('Datos de la empresa')
                ->schema([
                    Forms\Components\Select::make('company_id')
                        ->label('Empresa')
                        ->helperText('No pulsar el icono X para cambiar de empresa. Si lo pulsa se mostrará un error. Pulse F5 para actualizar el registro.')
                        ->relationship('company', 'company')
                        ->searchable()
                        ->required()
                        ->preload()
                        ->createOptionForm([
                            Forms\Components\TextInput::make('company')
                                ->label('Nombre de Empresa')
                                ->required(),
                            Forms\Components\Select::make('groupcompany_id')
                                ->label('Grupo Empresarial')
                                ->relationship('groupcompany', 'name')
                                ->preload()
                                ->searchable()
                        ])
                        ->createOptionUsing(function (array $data): int {
                            $newcompany = Company::create([
                                'company' => $data['company'] = Str::upper($data['company']),
                                'groupcompany_id' => $data['groupcompany_id']
                            ]);
    
                            return $newcompany->id;
                        })
                        ->editOptionForm([
                            Forms\Components\TextInput::make('company')
                                ->label('Nombre de Empresa')    
                                ->required(),
                            Forms\Components\Select::make('groupcompany_id')
                                ->label('Grupo Empresarial')
                                ->preload()
                                ->relationship('groupcompany', 'name')
                                ->searchable()
                        ])
                        ->afterStateUpdated(function (Set $set, Get $get) {
                            $company = Company::findOrfail($get('company_id'));                
                            $set('groupcompany_id2', $company->groupcompany_id);
                        })
                    ->live()
                    ->optionsLimit(5),
                    Forms\Components\Select::make('groupcompany_id2')
                        ->label('Grupo Empresarial')
                        ->preload()
                        ->live()
                        ->relationship('groupcompany', 'name'),
                ])
                ->compact()
                ->columns(2),
                
                Section::make('Datos económicos')
                ->schema([
                    Forms\Components\TextInput::make('student_cost')
                        ->label('Coste Alumno')
                        ->required()
                        ->numeric()
                        ->prefix('€')
                        ->live(onBlur: true)
                        ->afterStateUpdated(function (Set $set, Get $get) {
                            $nun_alum = $get('number_students');
                            $cost = $get('student_cost');
                            if ($cost > 0) {
                                $total_cost = $cost * $nun_alum;
                                $set('cost', $total_cost);
                                $set('project_cost', 0);
                            } else {
                                $set('cost', 0);
                            }
                        }),
                    Forms\Components\TextInput::make('project_cost')
                        ->label('Coste Proyecto')
                        ->helperText('Solo en el caso de no tener estipulado un coste por alumno.')
                        ->numeric()
                        ->prefix('€')
                        ->live(onBlur: true)
                        ->afterStateUpdated(function (Set $set, Get $get) {
                            $cost = $get('project_cost');
                            if ($cost > 0) {
                                $total_cost = $cost;
                                $set('cost', $total_cost);
                                $set('student_cost', 0);
                            } else {
                                $set('cost', 0);
                            }
                        }),
                    Forms\Components\TextInput::make('cost')
                        ->label('Coste Total')
                        ->required()
                        ->readonly()
                        ->numeric()
                        ->prefix('€'),
                    Forms\Components\Select::make('billed_month')
                        ->label('Mes Facturación')
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
                        )
                        ->optionsLimit(5),
                ])
                ->compact()
                ->columns(4),

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
                        ->required()
                        ->onColor('success')
                        ->live()
                        ->afterStateUpdated(function ($state, Set $set) {
                            if ($state) {
                                $set('canceled', false);
                            }
                        }),
                    Forms\Components\Toggle::make('canceled')
                        ->label('Anulado')
                        ->required()
                        ->onColor('danger')
                        ->live()
                        ->afterStateUpdated(function ($state, Set $set) {
                            if ($state) {
                                $set('incident', false);
                            }
                        }),
                ])
                ->compact()
                ->columns(5),
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
                    ->sortable()
                    ->wrap(),
                Tables\Columns\TextColumn::make('modality')
                    ->label('Modalidad')
                    ->size(TextColumn\TextColumnSize::ExtraSmall)
                    ->alignment(Alignment::Center)
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\ColorColumn::make('platform.color')
                    ->label('Plataforma')
                    ->alignment(Alignment::Center),
                Tables\Columns\TextColumn::make('nhours')
                    ->label('Horas')
                    ->size(TextColumn\TextColumnSize::ExtraSmall)
                    ->alignment(Alignment::Center)
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('communication_date')
                    ->label('Comunicación')
                    ->size(TextColumn\TextColumnSize::ExtraSmall)
                    ->date('d-m-Y')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('start_date')
                    ->label('F.Inicio')
                    ->size(TextColumn\TextColumnSize::ExtraSmall)
                    ->date('d-m-Y')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('end_date')
                    ->label('F.Fin')
                    ->size(TextColumn\TextColumnSize::ExtraSmall)
                    ->date('d-m-Y')
                    ->searchable()
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
                    ->searchable()
                    ->sortable()
                    ->wrap(),
                Tables\Columns\TextColumn::make('groupcompany.name')
                    ->label('Grupo Empresas')
                    ->size(TextColumn\TextColumnSize::ExtraSmall)
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('observations')
                    ->label('Observaciones')
                    ->size(TextColumn\TextColumnSize::ExtraSmall)
                    ->wrap(),
                Tables\Columns\TextColumn::make('tutor.name')
                    ->label('Tutor')
                    ->size(TextColumn\TextColumnSize::ExtraSmall)
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('coordinator.name')
                    ->label('Coordinador')
                    ->size(TextColumn\TextColumnSize::ExtraSmall)
                    ->alignment(Alignment::Center)
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('agent.name')
                    ->label('Comercial')
                    ->size(TextColumn\TextColumnSize::ExtraSmall)
                    ->alignment(Alignment::Center)
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('supplier.name')
                    ->label('Proveedor')
                    ->size(TextColumn\TextColumnSize::ExtraSmall)
                    ->alignment(Alignment::Center)
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('course_type')
                    ->label('Tipo')
                    ->size(TextColumn\TextColumnSize::ExtraSmall),
                Tables\Columns\TextColumn::make('cost')
                    ->label('Coste')
                    ->size(TextColumn\TextColumnSize::ExtraSmall)
                    ->money('EUR'),
                Tables\Columns\TextColumn::make('billed_month')
                    ->label('Facturado')
                    ->size(TextColumn\TextColumnSize::ExtraSmall)
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\ToggleColumn::make('rlt')
                    ->label('RLT'),
                Tables\Columns\ToggleColumn::make('rlt_send')
                    ->label('RLT Enviada')
                    ->alignment(Alignment::Center),
                Tables\Columns\ToggleColumn::make('rlt_received')
                    ->label('RLT Recibida')
                    ->alignment(Alignment::Center),
                Tables\Columns\ToggleColumn::make('rlt_faborable')
                    ->label('RLT Favorable')
                    ->alignment(Alignment::Center)
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\ToggleColumn::make('rlt_incident')
                    ->label('RLT Desfavorable')
                    ->alignment(Alignment::Center)
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\IconColumn::make('incident')
                    ->label('Incidentado')
                    ->alignment(Alignment::Center)
                    ->boolean(),
                Tables\Columns\IconColumn::make('canceled')
                    ->label('Anulado')
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
                Filter::make('F_Inicio')
                    ->label('Hola')
                    ->form([
                        DatePicker::make('start_date')->label('Inicio'),
                        DatePicker::make('end_date')->label('Fin'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['start_date'],
                                fn (Builder $query, $date): Builder => $query->whereDate('start_date', '>=', $date),
                            )
                            ->when(
                                $data['end_date'],
                                fn (Builder $query, $date): Builder => $query->whereDate('end_date', '<=', $date),
                            );
                    }),
                SelectFilter::make('tutors')
                    ->relationship('tutor', 'name')
                    ->label('Tutor'),
                SelectFilter::make('coordinators')
                    ->relationship('coordinator', 'name')
                    ->label('Coordinador'),
                SelectFilter::make('agents')
                    ->relationship('agent', 'name')
                    ->label('Agente'),
                SelectFilter::make('companies')
                    ->relationship('company', 'company')
                    ->label('Empresa'),
                SelectFilter::make('platforms')
                    ->relationship('platform', 'name')
                    ->label('Plataforma'),
                SelectFilter::make('course_type')
                    ->options([
                        'bonificado' => 'Bonificado',
                        'gestionado' => 'Gestionado',
                        'impartido' => 'Impartido',
                        'privado' => 'Privado'
                    ])
                    ->label('Tipo Curso')                
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
                function (Programming $record) {
                    if ($record->canceled == 1) {
                        return 'my-line-bg-canceled';
                    } elseif($record->incident == 1) {
                        return 'my-line-bg-incident';
                    } else {
                        return null;
                    }
                }
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
