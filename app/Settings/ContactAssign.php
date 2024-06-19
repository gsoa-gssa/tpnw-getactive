<?php

namespace App\Settings;

use Spatie\LaravelSettings\Settings;

class ContactAssign extends Settings
{
    public array $canton_rules = [
        [
            "canton" => "AG",
            "user_id" => 1,
        ]
    ];

    public static function group(): string
    {
        return 'conactassign';
    }
}
