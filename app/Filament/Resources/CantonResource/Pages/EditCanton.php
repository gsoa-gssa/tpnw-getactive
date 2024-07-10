<?php

namespace App\Filament\Resources\CantonResource\Pages;

use App\Filament\Resources\CantonResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditCanton extends EditRecord
{
    protected static string $resource = CantonResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
