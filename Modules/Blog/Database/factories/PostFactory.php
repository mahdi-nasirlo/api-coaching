<?php

namespace Modules\Blog\Database\factories;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Modules\Blog\Entities\BlogCategory;

class PostFactory extends Factory
{
    protected $model = \Modules\Blog\Entities\Post::class;

    public function definition(): array
    {
        return [
            'title' => $this->faker->word,
            'slug' => Str::uuid(),
            'content' => $this->faker->paragraph,
            'view' => rand(200, 12240),
            'read_time' => rand(1240, 100000),
            'published_at' => Carbon::now()->addMinutes(rand(0,60*24*5)),
            'image' => '/default.jpg',
            'user_id' => User::factory()->create()->id,
            'category_id' => BlogCategory::factory()->create()->id
        ];
    }
}

