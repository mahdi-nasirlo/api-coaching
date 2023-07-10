<?php

namespace Modules\Meeting\Database\factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Meeting\Entities\Coach;
use Modules\Meeting\Entities\CoachInfo;
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
            'user_id' => User::factory()->create(),
            'info_id' => CoachInfo::factory(),
        ];
    }

    public function accepted(): Factory
    {
        return $this->state(function (array $attributes) {
            return [
                'status' => CoachStatusEnum::ACCEPTED->value,
            ];
        });
    }
}

