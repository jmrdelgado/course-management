<?php

namespace App\Filament\Resources\ActionResource\Pages;

use App\Filament\Resources\ActionResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

use Illuminate\Support\Str;

class EditAction extends EditRecord
{
    protected static string $resource = ActionResource::class;

    protected function mutateFormDataBeforeSave(array $data): array
    {
        $data['denomination'] = Str::upper($data['denomination']);

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
