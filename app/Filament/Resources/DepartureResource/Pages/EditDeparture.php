<?php

namespace App\Filament\Resources\DepartureResource\Pages;

use App\Filament\Resources\DepartureResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditDeparture extends EditRecord
{
    protected static string $resource = DepartureResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
