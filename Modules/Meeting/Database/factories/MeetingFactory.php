<?php

namespace Modules\Meeting\Database\factories;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Meeting\Entities\Coach;
use Modules\Meeting\Entities\Meeting;

class MeetingFactory extends Factory
{
    protected $model = Meeting::class;

    public function definition(): array
    {
        return [
            'body' => $this->faker->paragraph,
            'date' => Carbon::now()->addDays(rand(0, 20)),
            'start_time' => $this->faker->time,
            'end_time' => Carbon::parse($this->faker->time)->addHours(rand(1, 5)),
            'coach_id' => function () {
                return Coach::factory()->create()->id;
            },
        ];
    }
}

