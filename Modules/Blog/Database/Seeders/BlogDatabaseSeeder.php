<?php

namespace Modules\Blog\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Blog\Entities\BlogCategory;
use Modules\Blog\Entities\Post;

class BlogDatabaseSeeder extends Seeder
{
    public function run(): void
    {
        BlogCategory::factory()->create();
        Post::factory()->count(30)->create();
    }
}
