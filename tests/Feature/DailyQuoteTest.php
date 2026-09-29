<?php

use App\Models\User;
use App\Support\DailyQuote;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('everyone sees the same quote on the same day, and it changes the next day', function () {
    $this->travelTo(now()->setDate(2026, 9, 29)->setTime(8, 0));
    $morning = DailyQuote::for(today());

    $this->travelTo(now()->setTime(22, 30));
    expect(DailyQuote::for(today()))->toBe($morning);

    expect(DailyQuote::for(today()->addDay()))->not->toBe($morning);
});

test('the dashboard shows the quote of the day with its author', function () {
    $quote = DailyQuote::for(today());

    $this->actingAs(User::factory()->create())->get('/dashboard')
        ->assertOk()
        ->assertSee('Quote of the day')
        ->assertSee($quote['text'])
        ->assertSee($quote['author']);
});
