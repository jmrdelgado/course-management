<?php

namespace App\Filament\Resources\ProgrammingResource\Pages;

use App\Filament\Resources\ProgrammingResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListProgrammings extends ListRecords
{
    protected static string $resource = ProgrammingResource::class;

    protected static ?string $title = 'Programación de Cursos';

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->label('Crear Nuevo Curso'),
        ];
    }
}
