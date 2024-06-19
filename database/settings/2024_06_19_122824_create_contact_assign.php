<?php

use Spatie\LaravelSettings\Migrations\SettingsMigration;

return new class extends SettingsMigration
{
    public function up(): void
    {
        $this->migrator->add('conactassign.canton_rules', [
                [
                    "canton" => "AG",
                    "user_id" => "1",
                ],
                [
                    "canton" => "AI",
                    "user_id" => "1",
                ],
                [
                    "canton" => "AR",
                    "user_id" => "1",
                ],
                [
                    "canton" => "BE",
                    "user_id" => "1",
                ],
                [
                    "canton" => "BL",
                    "user_id" => "1",
                ],
                [
                    "canton" => "BS",
                    "user_id" => "1",
                ],
                [
                    "canton" => "FR",
                    "user_id" => "1",
                ],
                [
                    "canton" => "GE",
                    "user_id" => "1",
                ],
                [
                    "canton" => "GL",
                    "user_id" => "1",
                ],
                [
                    "canton" => "GR",
                    "user_id" => "1",
                ],
                [
                    "canton" => "JU",
                    "user_id" => "1",
                ],
                [
                    "canton" => "LU",
                    "user_id" => "1",
                ],
                [
                    "canton" => "NE",
                    "user_id" => "1",
                ],
                [
                    "canton" => "NW",
                    "user_id" => "1",
                ],
                [
                    "canton" => "OW",
                    "user_id" => "1",
                ],
                [
                    "canton" => "SG",
                    "user_id" => "1",
                ],
                [
                    "canton" => "SH",
                    "user_id" => "1",
                ],
                [
                    "canton" => "SO",
                    "user_id" => "1",
                ],
                [
                    "canton" => "SZ",
                    "user_id" => "1",
                ],
                [
                    "canton" => "TG",
                    "user_id" => "1",
                ],
                [
                    "canton" => "TI",
                    "user_id" => "1",
                ],
                [
                    "canton" => "UR",
                    "user_id" => "1",
                ],
                [
                    "canton" => "VD",
                    "user_id" => "1",
                ],
                [
                    "canton" => "VS",
                    "user_id" => "1",
                ],
                [
                    "canton" => "ZG",
                    "user_id" => "1",
                ],
                [
                    "canton" => "ZH",
                    "user_id" => "1",
                ]
        ]);
    }

    public function down(): void
    {
        $this->migrator->delete('conactassign.canton_rules');
    }
};
