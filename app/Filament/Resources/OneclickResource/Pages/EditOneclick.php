<?php

namespace App\Filament\Resources\OneclickResource\Pages;

use App\Filament\Resources\OneclickResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditOneclick extends EditRecord
{
    protected static string $resource = OneclickResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    /**
     * Redirect after successful update.
     */
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('view', ['record' => $this->getRecord()]);
    }
}
