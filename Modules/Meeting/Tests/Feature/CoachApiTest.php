<?php

use Modules\Meeting\Entities\Coach;
use Modules\Meeting\Enums\CoachStatusEnum;
use function Pest\Laravel\getJson;

uses(
    Tests\TestCase::class,
    Illuminate\Foundation\Testing\RefreshDatabase::class,
);


it('return a list of all coach (v1)', function ()
{
    $coachPrePage = config('app.pagination_per_page.coach');
    Coach::factory()
        ->count(30)
        ->accepted()
        ->create();

    $res = getJson(route('coach.index'));

    $res->assertStatus(200);
    $res->assertJsonCount($coachPrePage, 'data');
    $res->assertJsonPath('meta.last_page', Coach::all()->count() / $coachPrePage);
});
