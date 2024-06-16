<?php

namespace App\Filament\Resources\SignupResource\Pages;

use App\Filament\Resources\SignupResource;
use Filament\Actions;
use Filament\Resources\Pages\viewRecord;
use Parallax\FilamentComments\Actions\CommentsAction;

class ViewSignup extends viewRecord
{
    protected static string $resource = SignupResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CommentsAction::make(),
            Actions\Action::make("edit")
                ->label("Edit Signup")
                ->icon("heroicon-o-pencil")
                ->url(fn () => route("filament.admin.resources.signups.edit", $this->record)),
        ];
    }
}
