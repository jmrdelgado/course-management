<?php

namespace App\Filament\Resources\GroupCompanyResource\Pages;

use App\Filament\Resources\GroupCompanyResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

use Illuminate\Support\Str;

class EditGroupCompany extends EditRecord
{
    protected static string $resource = GroupCompanyResource::class;

    protected static ?string $title = 'Grupos Empresariales';

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
