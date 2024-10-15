<?php

namespace App\Filament\Resources\CoordinatorResource\Pages;

use App\Filament\Resources\CoordinatorResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

use Illuminate\Support\Str;

class EditCoordinator extends EditRecord
{
    protected static string $resource = CoordinatorResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        $data['name'] = Str::upper($data['name']);

        return $data;
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
