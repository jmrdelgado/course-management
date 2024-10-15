<?php

namespace App\Filament\Resources\GroupCompanyResource\Pages;

use App\Filament\Resources\GroupCompanyResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListGroupCompanies extends ListRecords
{
    protected static string $resource = GroupCompanyResource::class;

    protected static ?string $title = 'Grupos Empresariales';

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->label('Crear Grupo de Empresas'),
        ];
    }
}
