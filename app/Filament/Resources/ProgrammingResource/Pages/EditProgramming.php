<?php

namespace App\Filament\Resources\ProgrammingResource\Pages;

use App\Filament\Resources\ProgrammingResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Filament\Notifications\Actions\Action;
use Filament\Notifications\Notification;

class EditProgramming extends EditRecord
{
    protected static string $resource = ProgrammingResource::class;

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

    protected function mutateFormDataBeforeSave(array $data): array
    {
        $data['last_edited_by_id'] = auth()->id();

        if ($data['canceled'] == true) {
            $recipient = auth()->user();

            Notification::make()
            ->title('¡¡CURSO ANULADO!!')
            ->success()
            ->body('La Acción ' . $data['naction'] . ' - ' . $data['ngroup'] . ' ha sido anulada')
            ->actions([
                Action::make('view')
                    ->label('Marcar como leída')
                    ->button()
                    ->markAsRead(),
                Action::make('markAsUnread')
                    ->label('No leída')
                    ->button()
                    ->markAsUnread(),
            ])
            ->send($recipient)
            ->sendToDatabase($recipient);
        } elseif ($data['incident'] == true) {
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
                Action::make('markAsUnread')
                    ->label('No leída')
                    ->button()
                    ->markAsUnread(),
            ])
            ->send($recipient)
            ->sendToDatabase($recipient);
        }
        
        return $data;
    }
}
