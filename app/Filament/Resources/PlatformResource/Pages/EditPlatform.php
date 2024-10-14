<?php

namespace App\Filament\Resources\PlatformResource\Pages;

use App\Filament\Resources\PlatformResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

use Illuminate\Support\Str;

class EditPlatform extends EditRecord
{
    protected static string $resource = PlatformResource::class;

    protected function mutateFormDataBeforeSave(array $data): array
    {
        $data['name'] = Str::upper($data['name']);

        return $data;
    }

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
