<?php

namespace App\Filament\Resources\AgentResource\Pages;

use App\Filament\Resources\AgentResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

use Illuminate\Support\Str;

class EditAgent extends EditRecord
{
    protected static string $resource = AgentResource::class;

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
