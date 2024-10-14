<?php

namespace App\Filament\Resources\ActionResource\Pages;

use App\Filament\Resources\ActionResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

use Illuminate\Support\Str;

class CreateAction extends CreateRecord
{
    protected static string $resource = ActionResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['denomination'] = Str::upper($data['denomination']);
    
        return $data;
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
