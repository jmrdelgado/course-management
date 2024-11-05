<?php

namespace App\Filament\Resources\DepartureResource\Pages;

use App\Filament\Resources\DepartureResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateDeparture extends CreateRecord
{
    protected static string $resource = DepartureResource::class;

    protected static ?string $title = 'Nueva Salida';

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
