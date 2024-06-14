<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Event;

class EventFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Event::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'date' => $this->faker->date(),
            'canton' => $this->faker->randomElement(["AG","AR","AI","BL","BS","BE","FR","GE","GL","GR","JU","LU","NE","NW","OW","SG","SH","SO","SZ","TG","TI","UR","VD","VS","ZG","ZH"]),
            'location' => $this->faker->word(),
            'contact' => $this->faker->word(),
            'type' => $this->faker->randomElement(["signaturecollection","certification"]),
        ];
    }
}
