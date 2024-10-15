<?php

namespace App\Filament\Resources\AgentResource\Pages;

use App\Filament\Resources\AgentResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

use Illuminate\Support\Str;

class CreateAgent extends CreateRecord
{
    protected static string $resource = AgentResource::class;

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
