<?php

namespace App\Filament\Resources\ProgrammingResource\Pages;

use App\Filament\Resources\ProgrammingResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateProgramming extends CreateRecord
{
    protected static string $resource = ProgrammingResource::class;

    protected static ?string $title = 'Nuevo Curso';

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
