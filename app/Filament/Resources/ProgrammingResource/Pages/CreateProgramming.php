<?php

namespace App\Filament\Resources\ProgrammingResource\Pages;

use App\Filament\Resources\ProgrammingResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Filament\Notifications\Actions\Action;
use Filament\Notifications\Notification;

class CreateProgramming extends CreateRecord
{
    protected static string $resource = ProgrammingResource::class;

    protected static ?string $title = 'Nuevo Curso';

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['user_id'] = auth()->id();

        if ($data['incident'] == true) {
            $recipient = auth()->user();

            Notification::make()
            ->title('¡¡CURSO INCIDENTADO!!')
            ->success()
            ->body('La Acción ' . $data['naction'] . ' - ' . $data['ngroup'] . ' ha sido incidentada. Motivo: ' . $data['observations'])
            ->actions([
                Action::make('view')
                    ->label('Marcar como leída')
                    ->button()
                    ->markAsRead(),
            ])
            ->send($recipient)
            ->sendToDatabase($recipient);
        }
            
        return $data;
    }
}
