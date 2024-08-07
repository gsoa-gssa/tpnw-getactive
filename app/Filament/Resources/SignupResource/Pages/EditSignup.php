<?php

namespace App\Filament\Resources\SignupResource\Pages;

use App\Filament\Resources\SignupResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditSignup extends EditRecord
{
    protected static string $resource = SignupResource::class;

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
