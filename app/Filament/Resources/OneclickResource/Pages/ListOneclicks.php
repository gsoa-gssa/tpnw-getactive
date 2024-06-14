<?php

namespace App\Filament\Resources\OneclickResource\Pages;

use App\Filament\Resources\OneclickResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListOneclicks extends ListRecords
{
    protected static string $resource = OneclickResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
