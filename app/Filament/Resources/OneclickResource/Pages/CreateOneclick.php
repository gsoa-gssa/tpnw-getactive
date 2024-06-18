<?php

namespace App\Filament\Resources\OneclickResource\Pages;

use App\Filament\Resources\OneclickResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateOneclick extends CreateRecord
{
    protected static string $resource = OneclickResource::class;

    /**
     * Redirect after successful creation.
     */
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('view', ['record' => $this->getRecord()]);
    }
}
