<?php

namespace Modules\Meeting\Database\factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class CoachInfoFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = \Modules\Meeting\Entities\CoachInfo::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {
        return [
            'about_me' => $this->faker->paragraph(2),
            'resume' => $this->faker->paragraph(5),
            'job_experience' => $this->faker->paragraph(),
            'education_record' => $this->faker->paragraph(2),
        ];
    }
}

