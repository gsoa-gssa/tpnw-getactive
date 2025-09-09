<?php

namespace App\Filament\Resources\EventResource\Pages;

use App\Filament\Resources\EventResource;
use Filament\Actions\Action;
use Filament\Actions\ActionGroup;
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
            ActionGroup::make([
                Action::make('Edit Event')
                    ->icon('heroicon-o-pencil')
                    ->label(__('buttonlabels.edit.event'))
                    ->url(route('filament.admin.resources.events.edit', ['record' => $this->record])),
                Action::make('Duplicate Event')
                    ->icon('heroicon-o-document-duplicate')
                    ->label(__('buttonlabels.duplicate.event'))
                    ->action(function (Event $event) {
                        $newEvent = $event->replicate();
                        $newEvent->name = $event->name;
                        $newEvent->save();

                        return redirect()->route('filament.admin.resources.events.edit', ['record' => $newEvent->id]);
                    }),
            ])
            ->label('Edit')
            ->icon('heroicon-o-pencil')
            ->color('primary'),

            ActionGroup::make([
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
            ])
            ->label('View')
            ->icon('heroicon-o-eye')
            ->color('info'),

            ActionGroup::make([
                Action::make('publish_event')
                    ->label('Publish Event')
                    ->icon('heroicon-o-eye')
                    ->color('success')
                    ->requiresConfirmation()
                    ->visible(fn() => !$this->record->visibility)
                    ->action(function(Event $event) {
                        $event->update(['visibility' => true]);
                        \Filament\Notifications\Notification::make()
                            ->title('Event Published')
                            ->success()
                            ->send();
                    }),
                Action::make('hide_event')
                    ->label('Hide Event')
                    ->icon('heroicon-o-eye-slash')
                    ->color('danger')
                    ->requiresConfirmation()
                    ->visible(fn() => $this->record->visibility)
                    ->action(function(Event $event) {
                        $event->update(['visibility' => false]);
                        \Filament\Notifications\Notification::make()
                            ->title('Event Hidden')
                            ->success()
                            ->send();
                    }),
                Action::make('set_definitive')
                    ->label('Set as Definitive')
                    ->icon('heroicon-o-document-check')
                    ->color('success')
                    ->requiresConfirmation()
                    ->visible(fn() => !$this->record->definitive)
                    ->action(function(Event $event) {
                        $event->update(['definitive' => true]);
                        \Filament\Notifications\Notification::make()
                            ->title('Event Set as Definitive')
                            ->success()
                            ->send();
                    }),
                Action::make('set_draft')
                    ->label('Set as Draft')
                    ->icon('heroicon-o-document-minus')
                    ->color('warning')
                    ->requiresConfirmation()
                    ->visible(fn() => $this->record->definitive)
                    ->action(function(Event $event) {
                        $event->update(['definitive' => false]);
                        \Filament\Notifications\Notification::make()
                            ->title('Event Set as Draft')
                            ->success()
                            ->send();
                    }),
            ])
            ->label('Attributes')
            ->icon('heroicon-o-cog-6-tooth')
            ->color('warning'),
        ];
    }
}
