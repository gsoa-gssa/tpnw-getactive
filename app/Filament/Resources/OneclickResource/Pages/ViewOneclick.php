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
            CopyAction::make()->copyable(
                    function (Oneclick $oneclick) {
                        $url = route('oneclick.createSignup', $oneclick);
                        foreach ($oneclick->fields as $field) {
                            $separator = strpos($url, "?") === false ? "?" : "&";
                            $url .= $separator . $field["field"] . "=" . $field["value"];
                        }
                        return $url;
                    }
                )
        ];
    }
}
