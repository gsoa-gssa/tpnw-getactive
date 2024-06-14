<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Event;
use App\Models\Oneclick;

class OneclickFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Oneclick::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'fields' => '{}',
            'successmessages' => '{}',
            'event_id' => Event::factory(),
        ];
    }
}
