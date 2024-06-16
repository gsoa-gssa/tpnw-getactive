<?php

namespace App\Filament\Resources\EventResource\Pages;

use App\Filament\Resources\EventResource;
use Filament\Actions\Action;
use Filament\Resources\Pages\viewRecord;

class ViewEvent extends viewRecord
{
    protected static string $resource = EventResource::class;

    /**
     * Header Actions
     */
    protected function getHeaderActions() : array {
        return [
            Action::make('Edit Event')
                ->icon('heroicon-o-pencil')
                ->url(route('filament.admin.resources.events.edit', ['record' => $this->record])),
        ];
    }
}
