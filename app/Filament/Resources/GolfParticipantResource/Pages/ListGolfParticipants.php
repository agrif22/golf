<?php

namespace App\Filament\Resources\GolfParticipantResource\Pages;

use App\Filament\Resources\GolfParticipantResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListGolfParticipants extends ListRecords
{
    protected static string $resource = GolfParticipantResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
