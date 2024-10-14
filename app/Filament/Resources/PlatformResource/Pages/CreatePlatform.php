<?php

namespace App\Filament\Resources\PlatformResource\Pages;

use App\Filament\Resources\PlatformResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

use Illuminate\Support\Str;

class CreatePlatform extends CreateRecord
{
    protected static string $resource = PlatformResource::class;

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
