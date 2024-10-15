<?php

namespace App\Filament\Resources\CoordinatorResource\Pages;

use App\Filament\Resources\CoordinatorResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

use Illuminate\Support\Str;

class CreateCoordinator extends CreateRecord
{
    protected static string $resource = CoordinatorResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['name'] = Str::upper($data['name']);
    
        return $data;
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
