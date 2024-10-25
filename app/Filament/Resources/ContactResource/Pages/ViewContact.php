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
            Action::make("email")
                ->label(__("contact.pages.view.actions.header.email.label"))
                ->icon("heroicon-o-at-symbol")
                ->url(
                    function () {
                        $subject = __("contact.pages.view.actions.header.email.subject");
                        $body = str_replace("+", "%20", urlencode(__("contact.pages.view.actions.header.email.body", [
                            "contactname" => $this->record->firstname,
                            "user" => auth()->user()->name,
                        ])));
                        return <<<EOD
                        mailto:{$this->record->email}
                        ?subject={$subject}
                        &body={$body}
                        EOD;
                    }
                )
        ];
    }
}
