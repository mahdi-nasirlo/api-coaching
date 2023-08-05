<?php

namespace Modules\Meeting\Database\factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Modules\Meeting\Entities\CoachCategory;

class CoachCategoryFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = CoachCategory::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->word,
            'slug' => Str::uuid(),
            'is_visible' => $this->faker->boolean,
            'parent_id' => null,
            '_lft' => 0,
            '_rgt' => 0,
        ];
    }
}

