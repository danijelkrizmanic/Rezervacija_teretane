<?php

use App\Models\Reservation;
use App\Models\Room;
use App\Models\Termin;
use App\Models\User;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Carbon;

uses(RefreshDatabase::class);

beforeEach(function (): void {
    $this->seed(DatabaseSeeder::class);
});

afterEach(function (): void {
    Carbon::setTestNow();
});

test('user role can only access termins and personal reservations', function (): void {
    $user = User::factory()->create();
    $user->assignRole('user');

    $this->actingAs($user)->get(route('termins.index'))->assertOk();
    $this->actingAs($user)->get(route('reservations.index'))->assertOk();

    $this->actingAs($user)->get(route('rooms.index'))->assertForbidden();
    $this->actingAs($user)->get(route('users.index'))->assertForbidden();
    $this->actingAs($user)->post(route('termins.store'))->assertForbidden();
});

test('trainer role can access termins and rooms only', function (): void {
    $trainer = User::factory()->create();
    $trainer->assignRole('trainer');

    $this->actingAs($trainer)->get(route('termins.index'))->assertOk();
    $this->actingAs($trainer)->get(route('rooms.index'))->assertOk();

    $this->actingAs($trainer)->get(route('reservations.index'))->assertForbidden();
    $this->actingAs($trainer)->get(route('users.index'))->assertForbidden();
});

test('admin role can access rooms termins and users only', function (): void {
    $admin = User::factory()->create();
    $admin->assignRole('admin');

    $this->actingAs($admin)->get(route('termins.index'))->assertOk();
    $this->actingAs($admin)->get(route('rooms.index'))->assertOk();
    $this->actingAs($admin)->get(route('users.index'))->assertOk();

    $this->actingAs($admin)->get(route('reservations.index'))->assertForbidden();
});

test('user role only sees upcoming termins on the termins page', function (): void {
    $this->travelTo(Carbon::parse('2026-06-01 10:00:00'));

    $member = User::factory()->create();
    $member->assignRole('user');

    $trainer = User::factory()->create();
    $trainer->assignRole('trainer');

    $pastRoom = Room::create([
        'name' => 'Past Studio',
        'max_capacity' => 10,
    ]);
    $futureRoom = Room::create([
        'name' => 'Future Studio',
        'max_capacity' => 10,
    ]);

    $trainer->termins()->create([
        'room_id' => $pastRoom->id,
        'date' => '2026-06-01',
        'start_time' => '09:00',
        'end_time' => '10:00',
    ]);
    $trainer->termins()->create([
        'room_id' => $futureRoom->id,
        'date' => '2026-06-01',
        'start_time' => '11:00',
        'end_time' => '12:00',
    ]);

    $this->actingAs($member)
        ->get(route('termins.index'))
        ->assertOk()
        ->assertSee('Future Studio')
        ->assertDontSee('Past Studio');
});

test('trainer cannot update attendance before the training starts', function (): void {
    $this->travelTo(Carbon::parse('2026-06-01 09:00:00'));

    $trainer = User::factory()->create();
    $trainer->assignRole('trainer');

    $member = User::factory()->create();
    $member->assignRole('user');

    $room = Room::create([
        'name' => 'Morning Studio',
        'max_capacity' => 10,
    ]);

    $termin = Termin::create([
        'user_id' => $trainer->id,
        'room_id' => $room->id,
        'date' => '2026-06-01',
        'start_time' => '10:00',
        'end_time' => '11:00',
    ]);

    $reservation = Reservation::create([
        'user_id' => $member->id,
        'termin_id' => $termin->id,
    ]);

    $this->actingAs($trainer)
        ->put(route('reservations.update', $reservation), [
            'attended' => 1,
            'user_id' => $member->id,
        ])
        ->assertSessionHas('error');

    expect($reservation->refresh()->attended)->toBeFalse();
});
