<?php

use App\Models\User;
use App\Support\Milestones;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('a baby reminder focuses on the current age group and lists earlier unticked items as overdue', function () {
    $user = User::factory()->create([
        'parent_type' => 'new_parent',
        'child_date'  => today()->subMonths(3)->subDays(3)->toDateString(),
    ]);

    $reminders = Milestones::remindersFor($user, ['baby-first-smile']);

    expect($reminders['stage'])->toBe('Your baby is 3 months old')
        ->and($reminders['group'])->toBe('2–4 months')
        ->and(collect($reminders['due'])->pluck('label')->all())->toBe(['Holds head steady', 'Pushes up (tummy time)', 'Coos and babbles', 'Laughs out loud'])
        ->and(collect($reminders['overdue'])->pluck('label')->all())->toBe(['Responds to sounds', 'Focuses on faces', 'Follows moving objects'])
        ->and($reminders['next'])->toBe('4–6 months');
});

test('a pregnancy reminder follows the trimester', function () {
    $user = User::factory()->create([
        'parent_type' => 'expecting',
        'child_date'  => today()->addWeeks(12)->toDateString(),
    ]);

    $reminders = Milestones::remindersFor($user, []);

    expect($reminders['stage'])->toBe('Week 28 · Third trimester')
        ->and($reminders['group'])->toBe('Third trimester')
        ->and($reminders['due'])->toHaveCount(5)
        ->and($reminders['overdue'])->toHaveCount(6)
        ->and($reminders['next'])->toBeNull();
});

test('there are no reminders without a date', function () {
    $user = User::factory()->create(['parent_type' => 'new_parent', 'child_date' => null]);

    expect(Milestones::remindersFor($user, []))->toBeNull();

    $this->actingAs($user)->get('/dashboard')
        ->assertSee("Add your baby's birthday", false)
        ->assertDontSee('id="reminder"', false);
});

test('the dashboard shows the coming up card with the current group marked', function () {
    $user = User::factory()->create([
        'parent_type' => 'working_parent',
        'child_date'  => today()->subMonths(5)->toDateString(),
    ]);

    $this->actingAs($user)->get('/dashboard')
        ->assertOk()
        ->assertSee('Coming up')
        ->assertSee('Your baby is 5 months old')
        ->assertSee('data-tick="baby-rolls-over"', false)
        ->assertSee('<span class="ms-now">Now</span>', false);
});

test('once everything due is ticked the card says all caught up', function () {
    $user = User::factory()->create([
        'parent_type' => 'new_parent',
        'child_date'  => today()->subWeeks(2)->toDateString(),
    ]);
    foreach (Milestones::groupsFor('new_parent')['0–2 months'] as $item) {
        $user->milestoneChecks()->create(['milestone_key' => $item['key']]);
    }

    $this->actingAs($user)->get('/dashboard')
        ->assertSee('Your baby is under a month old')
        ->assertSee('All caught up for 0–2 months.')
        ->assertDontSee('data-tick=', false);
});
