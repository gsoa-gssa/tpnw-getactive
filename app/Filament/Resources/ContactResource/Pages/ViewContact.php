<?php

namespace App\Filament\Resources\ContactResource\Pages;

use Filament\Actions;
use Filament\Actions\Action;
use Filament\Resources\Pages\ViewRecord;
use App\Filament\Resources\ContactResource;

class ViewContact extends ViewRecord
{
    protected static string $resource = ContactResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Action::make("edit")
                ->label("Edit Contact")
                ->icon("heroicon-o-pencil")
                ->url(fn () => route("filament.admin.resources.contacts.edit", $this->record)),
        ];
    }
}
