<?php

namespace App\Filament\Pages;

use App\Models\User;
use App\Settings\ContactAssign;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Pages\SettingsPage;

class ContactAssignPage extends SettingsPage
{
    protected static ?string $navigationIcon = 'heroicon-o-cog-6-tooth';
    protected static ?string $navigationGroup = 'System Settings';

    protected static ?int $navigationSort = 20;

    /**
     * Title of the page.
     */
    public function getTitle(): string|\Illuminate\Contracts\Support\Htmlable
    {
        return __('pages.title.contact_assign');
    }

    /**
     * Navigation Label of the page.
     */
    public static function getNavigationLabel(): string
    {
        return __('pages.title.contact_assign');
    }

    protected static string $settings = ContactAssign::class;

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Repeater::make("canton_rules")
                    ->schema([
                        Forms\Components\Select::make("canton")
                            ->options([
                                "AG" => __("cantons.AG"),
                                "AR" => __("cantons.AR"),
                                "AI" => __("cantons.AI"),
                                "BL" => __("cantons.BL"),
                                "BS" => __("cantons.BS"),
                                "BE" => __("cantons.BE"),
                                "FR" => __("cantons.FR"),
                                "GE" => __("cantons.GE"),
                                "GL" => __("cantons.GL"),
                                "GR" => __("cantons.GR"),
                                "JU" => __("cantons.JU"),
                                "LU" => __("cantons.LU"),
                                "NE" => __("cantons.NE"),
                                "NW" => __("cantons.NW"),
                                "OW" => __("cantons.OW"),
                                "SG" => __("cantons.SG"),
                                "SH" => __("cantons.SH"),
                                "SO" => __("cantons.SO"),
                                "SZ" => __("cantons.SZ"),
                                "TG" => __("cantons.TG"),
                                "TI" => __("cantons.TI"),
                                "UR" => __("cantons.UR"),
                                "VD" => __("cantons.VD"),
                                "VS" => __("cantons.VS"),
                                "ZG" => __("cantons.ZG"),
                                "ZH" => __("cantons.ZH")
                            ])
                            ->searchable(),
                        Forms\Components\Select::make("user_id")
                            ->options(User::all()->pluck('name', 'id')->toArray())
                    ])
                    ->minItems(26)
                    ->maxItems(26)
                    ->columns(2)
            ]);
    }
}
