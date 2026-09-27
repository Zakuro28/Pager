<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

function journalOwner(): User
{
    $user = User::factory()->create(['parent_type' => 'new_parent']);

    $user->journalEntries()->create(['content' => 'Baby slept five hours straight!', 'mood' => 'happy', 'tags' => ['sleep']]);
    $user->journalEntries()->create(['content' => 'Rough night of feeding', 'mood' => 'tired', 'tags' => ['feeding', 'sleep']]);
    $user->journalEntries()->create(['content' => 'First real smile today', 'mood' => 'happy', 'tags' => ['milestone']]);

    return $user;
}

test('the journal can be searched by text, case-insensitively, with matches highlighted', function () {
    $this->actingAs(journalOwner())->get('/journal?q=SMILE')
        ->assertOk()
        ->assertSee('1 entry found')
        ->assertSee('First real <mark>smile</mark> today', false)
        ->assertDontSee('Rough night');
});

test('the journal can be filtered by mood and by tag', function () {
    $user = journalOwner();

    $this->actingAs($user)->get('/journal?mood=tired')
        ->assertSee('Rough night of feeding')
        ->assertDontSee('First real smile');

    $this->actingAs($user)->get('/journal?tag=sleep')
        ->assertSee('2 entries found')
        ->assertSee('Baby slept five hours')
        ->assertSee('Rough night of feeding')
        ->assertDontSee('First real smile');
});

test('search results only include your own entries', function () {
    journalOwner();
    $other = User::factory()->create();

    $this->actingAs($other)->get('/journal?q=smile')
        ->assertOk()
        ->assertSee('No entries match')
        ->assertDontSee('First real smile');
});

test('search text is escaped, not rendered as HTML', function () {
    $user = User::factory()->create();
    $user->journalEntries()->create(['content' => 'Tom & Jerry <b>night</b>']);

    $this->actingAs($user)->get('/journal?q=night')
        ->assertSee('Tom &amp; Jerry &lt;b&gt;<mark>night</mark>&lt;/b&gt;', false);
});

test('unknown filter values are ignored instead of erroring', function () {
    $this->actingAs(journalOwner())->get('/journal?mood=furious&tag=nope')
        ->assertOk()
        ->assertSee('Your timeline')
        ->assertSee('First real smile');
});

test('the dashboard applies filters from the url so search works without javascript', function () {
    $this->actingAs(journalOwner())->get('/dashboard?q=feeding')
        ->assertOk()
        ->assertSee('value="feeding"', false)
        ->assertSee('Rough night of <mark>feeding</mark>', false)
        ->assertDontSee('First real smile today');
});

test('entries are grouped by month and older ones load on the next page', function () {
    $user = User::factory()->create();
    foreach (range(1, 12) as $i) {
        $entry = $user->journalEntries()->create(['content' => "Entry number {$i}."]);
        $entry->forceFill(['created_at' => now()->subMinutes(12 - $i)])->save();
    }

    $this->actingAs($user)->get('/journal')
        ->assertSee(now()->format('F Y'))
        ->assertSee('Entry number 12.')
        ->assertDontSee('Entry number 2.')
        ->assertSee('Show older entries');

    $this->actingAs($user)->get('/journal?page=2')
        ->assertSee('Entry number 2.')
        ->assertDontSee('Show older entries');
});

test('deleting an entry says it was deleted, not saved', function () {
    $user  = journalOwner();
    $entry = $user->journalEntries()->first();

    $this->actingAs($user)->delete("/journal/{$entry->id}")
        ->assertRedirect('/dashboard')
        ->assertSessionHas('journal_deleted');

    $this->actingAs($user)->get('/dashboard')->assertSee('Entry deleted.');
});
