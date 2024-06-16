<?php

namespace App\Filament\Resources\EventResource\Pages;

use App\Filament\Resources\EventResource;
use Filament\Resources\Pages\Page;
use pxlrbt\FilamentActivityLog\Pages\ListActivities;


class ActivityLogPage extends ListActivities
{
    protected static string $resource = EventResource::class;
}
