<?php

namespace Modules\Meeting\Database\factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Meeting\Entities\Coach;
use Modules\Meeting\Enums\CoachStatusEnum;

class CoachFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Coach::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->name,
            'avatar' => '/default-avatar.jpg',
            'hourly_price' => rand(10, 200) * 1000,
            'status' => CoachStatusEnum::randomValue(),
        ];
    }
}

