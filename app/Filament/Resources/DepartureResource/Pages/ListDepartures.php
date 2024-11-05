<?php

namespace App\Filament\Resources\DepartureResource\Pages;

use App\Filament\Resources\DepartureResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListDepartures extends ListRecords
{
    protected static string $resource = DepartureResource::class;

    protected static ?string $title = 'Programación de Salidas';

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->label('Crear Nueva Salida'),
        ];
    }
}
