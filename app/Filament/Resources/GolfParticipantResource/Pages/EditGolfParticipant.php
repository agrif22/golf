<?php

namespace App\Filament\Resources\GolfParticipantResource\Pages;

use App\Filament\Resources\GolfParticipantResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditGolfParticipant extends EditRecord
{
    protected static string $resource = GolfParticipantResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
