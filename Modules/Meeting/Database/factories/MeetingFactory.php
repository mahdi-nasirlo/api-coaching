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
            'date' => now()->addDays(rand(0, 4))->format('Y-m-d'),
            'start_time' => $start_time = $this->faker->time,
            'end_time' => Carbon::parse($start_time)->addHours(rand(1, 5))->format("H:i:s"),
            'coach_id' => function () {
                return Coach::factory()->create()->id;
            },
        ];
    }
}

