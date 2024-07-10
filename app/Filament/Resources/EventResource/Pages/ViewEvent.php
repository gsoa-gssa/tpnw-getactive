<?php

namespace App\Filament\Resources\EventResource\Pages;

use App\Filament\Resources\EventResource;
use Filament\Actions\Action;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Event;
use Filament\Resources\Pages\viewRecord;
use Webbingbrasil\FilamentCopyActions\Pages\Actions\CopyAction;

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
            CopyAction::make()->copyable(
                function (Event $event) {
                    return route('signup.events', ["events" => $event->id]);
                }
            )->label(__("buttonlabels.copy.signuplink")),
            Action::make("print")
                ->label(__("buttonlabels.print.signups"))
                ->icon('heroicon-o-document-text')
                ->action(function(Event $event){
                    $pdf = Pdf::loadView("events.exports.signups", ["event" => $event])->setPaper('a4', 'landscape');
                    return response()->streamDownload(function () use ($pdf) {
                        echo $pdf->output();
                    }, "signups-{$event->name[app()->getLocale()]}-{$event->date}.pdf");
                }),
            Action::make("public")
                ->label(__("buttonlabels.publish"))
                ->icon('heroicon-o-eye')
                ->requiresConfirmation()
                ->action(function(Event $event){
                    $event->update(["visibility" => true]);
                    \Filament\Notifications\Notification::make()
                        ->title(__("notifications.event.published"))
                        ->success()
                        ->send();
                })->visible(fn() => !$this->record->visibility),
        ];
    }
}
