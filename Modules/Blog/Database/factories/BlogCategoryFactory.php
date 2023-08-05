<?php

namespace Modules\Blog\Database\factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class BlogCategoryFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = \Modules\Blog\Entities\BlogCategory::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->word,
            'slug' => Str::uuid(),
            'description' => $this->faker->paragraph,
            'is_visible' => $this->faker->boolean,
            'parent_id' => null,
            '_lft' => 0,
            '_rgt' => 0,
        ];
    }
}

