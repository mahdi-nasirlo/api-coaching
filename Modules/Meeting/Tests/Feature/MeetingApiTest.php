<?php

use App\Models\User;
use Carbon\Carbon;
use Modules\Meeting\Entities\BookingMeeting;
use Modules\Meeting\Entities\Coach;
use Modules\Meeting\Entities\Meeting;
use Modules\Meeting\Enums\MeetingStatusEnums;
use Modules\Payment\Entities\Cart;
use Nwidart\Modules\Facades\Module;

uses(
    Tests\TestCase::class,
    Illuminate\Foundation\Testing\RefreshDatabase::class,
);

it('can see list of meeting by coach username (v1)', function () {
    $coach = Coach::factory()->create();
    $meeting1 = Meeting::factory(['date' => now()])->create(['coach_id' => $coach->id]);
    $meeting2 = Meeting::factory(['date' => now()->subDay()])->create(['coach_id' => $coach->id]);
    $meeting1 = Meeting::factory(['date' => now()])->create(['coach_id' => $coach->id]);

    $bookingData = [
        'user_id' => User::query()->inRandomOrder()->first()->id,
        'coach_id' => $coach->id,
        'meeting_id' => $meeting1->id,
        'amount' => 0,
    ];

    if (Module::has("Payment")) {
        $bookingData['cart_id'] = Cart::query()->create(['amount' => 10000])->id;
    }

    BookingMeeting::query()->create($bookingData);

    $response = $this->get(route('meeting.getAll', ['coach' => $coach]));

    $response->assertStatus(200)
        ->assertJsonCount(2)
        ->assertJsonCount(2, now()->format('Y-m-d'))
        ->assertJsonFragment(['date' => now()->format('Y/m/d')])
        ->assertJsonFragment(['id' => $meeting1->id, 'body' => $meeting1->body])
        ->assertJsonFragment(['id' => $meeting2->id]);
});


it('coach can disable meeting (v1)', function () {
    $this->actingAs($user = User::factory()->create());
    $coach = Coach::factory(['user_id' => $user->id])->create();
    $meeting = Meeting::factory()->create(['coach_id' => $coach->id]);

    $response = $this->get(route('meeting.toggleStatus', $meeting));

    $response->assertStatus(200)
        ->assertJson(['status' => true, 'message' => 'meeting status is toggled']);

    $this->assertEquals(MeetingStatusEnums::DEACTIVATE, $meeting->fresh()->status);
});


it('can create meeting', function () {
    $this->actingAs($user = User::factory()->create());
    $coach = Coach::factory(['user_id' => $user->id])->create();
    $meetingData = [
        'coach_id' => $coach->id,
        'body' => fake()->paragraph,
        'start_time' => $start_time = fake()->time('H:i:s'),
        'end_time' => Carbon::parse($start_time)->addHours(2)->format('H:i:s'),
        'date' => now()->format('Y/m/d'),
    ];

    $response = $this->post(route('meeting.create', ['coach' => $coach]), $meetingData);

    $response->assertStatus(200)
        ->assertJson(['status' => 'true', 'message' => 'meeting create successfully']);

    $this->assertDatabaseHas('meetings', $meetingData);
});

it('validate time in creating meeting', function () {
    $this->actingAs($user = User::factory()->create());
    $coach = Coach::factory(['user_id' => $user->id])->create();
    $meetingData = [
        'coach_id' => $coach->id,
        'body' => fake()->paragraph,
        'start_time' => "23:10:00",
        'end_time' => "01:20:00",
        'date' => now()->format('Y/m/d'),
    ];

    $response = $this->post(route('meeting.create', ['coach' => $coach]), $meetingData);

    $response->assertStatus(422);
});

it('can\'t create meeting in other meeting time', function () {
    $this->actingAs($user = User::factory()->create());
    $coach = Coach::factory(['user_id' => $user->id])->create();
    $meetingData = Meeting::factory(['coach_id' => $coach->id])->create()->toArray();

    $response = $this->post(route('meeting.create', ['coach' => $coach]), $meetingData);

    $response->assertStatus(422);
});
