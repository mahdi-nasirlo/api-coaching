<?php

namespace Modules\Meeting\Database\Seeders;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;
use Modules\Meeting\Entities\Coach;
use Modules\Meeting\Entities\CoachCategory;

class CategoryMeetTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        Model::unguard();

        CoachCategory::factory()->count(20)->create();

        $categories = CoachCategory::all();

        Coach::query()->each(function (Coach $coach) use ($categories) {

            $categoryIds = $categories->random(rand(1, 3))->pluck('id')->toArray();

            $coach->categories()->syncWithoutDetaching($categoryIds);

        });
    }
}
