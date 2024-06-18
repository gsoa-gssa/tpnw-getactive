<?php

namespace App\Filament\Resources\OneclickResource\Pages;

use Filament\Actions;
use App\Models\Oneclick;
use Filament\Resources\Pages\ViewRecord;
use App\Filament\Resources\OneclickResource;
use Webbingbrasil\FilamentCopyActions\Pages\Actions\CopyAction;

class ViewOneclick extends ViewRecord
{
    protected static string $resource = OneclickResource::class;

    /**
     * Header Actions for the page.
     */
    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make("edit")
                ->icon("heroicon-o-pencil")
                ->url(fn () => route("filament.admin.resources.oneclicks.edit", $this->record)),
            Actions\ActionGroup::make([
                    CopyAction::make()->copyable(
                        function (Oneclick $oneclick) {
                            $url = "https://go.atomwaffenverbot.ch/oneclick/" . $oneclick->uuid;
                            foreach ($oneclick->fields as $field) {
                                $separator = strpos($url, "?") === false ? "?" : "&";
                                $url .= $separator . $field["field"] . "=" . $field["value"];
                            }
                            return $url;
                        }
                    )->label(__("actionlables.copy.de")),
                    CopyAction::make()->copyable(
                        function (Oneclick $oneclick) {
                            $url = "https://go.interdiction-armes-nucleaires.ch/oneclick/" . $oneclick->uuid;
                            foreach ($oneclick->fields as $field) {
                                $separator = strpos($url, "?") === false ? "?" : "&";
                                $url .= $separator . $field["field"] . "=" . $field["value"];
                            }
                            return $url;
                        }
                    )->label(__("actionlables.copy.fr")),
                    CopyAction::make()->copyable(
                        function (Oneclick $oneclick) {
                            $url = "https://go.divieto-armi-nucleari.ch/oneclick/" . $oneclick->uuid;
                            foreach ($oneclick->fields as $field) {
                                $separator = strpos($url, "?") === false ? "?" : "&";
                                $url .= $separator . $field["field"] . "=" . $field["value"];
                            }
                            return $url;
                        }
                    )->label(__("actionlables.copy.it")),
                ])
                ->button()
                ->label(__("actionlables.copy")),
        ];
    }
}
