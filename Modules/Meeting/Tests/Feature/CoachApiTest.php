<?php

use Illuminate\Http\UploadedFile;
use Modules\Meeting\Entities\Coach;
use Modules\Meeting\Entities\CoachCategory;
use Modules\Meeting\Enums\CoachStatusEnum;
use function Pest\Laravel\actingAs;
use function Pest\Laravel\getJson;

uses(
    Tests\TestCase::class,
    Illuminate\Foundation\Testing\RefreshDatabase::class,
);


it('return a list of all coach (v1)', function () {
    $coachPrePage = config('meeting.pagination_per_page.coach');
    Coach::factory()
        ->count(30)
        ->accepted()
        ->create();

    $res = getJson(route('coach.index'));

    $res->assertStatus(200);
    $res->assertJsonCount($coachPrePage, 'data');
    $res->assertJsonPath('meta.last_page', Coach::all()->count() / $coachPrePage);
});

it('user can fill coach data and hold it to accept request', closure: function () {

    $user = App\Models\User::factory()->create();
    actingAs($user);

    $categories = CoachCategory::factory()->count(20)->create();

    $coachData = [
        'name' => fake()->name,
        'categories' => $categories->random(rand(1, 2))->pluck('id')->toArray(),
        'hourly_price' => fake()->numberBetween(50000, 1000000),
        'about_me' => fake()->paragraph,
        'resume' => fake()->paragraph,
        'avatar' => UploadedFile::fake()->image('avatar.jpg'),
    ];

    $res = $this->postJson(route('coach.store'), $coachData);
    $res->assertStatus(201);

    $user->refresh();

    expect($user->coach->name)->toBe($coachData['name'])
        ->and($user->coach->coachInfo->about_me)->toBe($coachData['about_me'])
        ->and($user->coach->coachInfo->resume)->toBe($coachData['resume'])
        ->and($user->coach->status)->toBe(CoachStatusEnum::PENDING);
});

it('user cant\'t create coach if last time is make request ', function () {
    $coach = Coach::factory()->create();
    actingAs($coach->user);

    $categories = CoachCategory::factory()->count(20)->create();

    $coachData = [
        'name' => fake()->name,
        'categories' => $categories->random(rand(1, 2))->pluck('id')->toArray(),
        'hourly_price' => fake()->numberBetween(50000, 1000000),
        'about_me' => fake()->paragraph,
        'resume' => fake()->paragraph,
        'avatar' => UploadedFile::fake()->image('avatar.jpg'),
    ];

    $this->postJson(route('coach.store'), $coachData)
        ->assertJson(['status' => false])
        ->assertStatus(403);
});

it('can update coach info', function () {

    $user = \App\Models\User::factory()->create();
    actingAs($user);

    $categories = CoachCategory::factory()->count(20)->create();

    $coachData = [
        'name' => fake()->name,
        'user_name' => fake()->slug,
        'categories' => $categories->random(rand(1, 2))->pluck('id')->toArray(),
        'hourly_price' => fake()->numberBetween(50000, 1000000),
        'about_me' => fake()->paragraph,
        'resume' => fake()->paragraph,
        'avatar' => UploadedFile::fake()->image('avatar.jpg'),
    ];

    $res = $this->postJson(route('coach.store'), $coachData)
        ->assertStatus(201);

    $coachData['name'] = 'test user';

    $update = $this->postJson('api/v1/coach/' . $res->json()['data']['username'], $coachData);

    $coach = $user->refresh()->coach;

    expect($coach->name)->toBe('test user')
        ->and($coach->status)->toBe(CoachStatusEnum::PENDING);
});
