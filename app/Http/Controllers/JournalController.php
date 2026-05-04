<?php

namespace App\Http\Controllers;

use App\Models\JournalEntry;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class JournalController extends Controller
{
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'content' => ['required', 'string', 'max:2000'],
            'mood'    => ['nullable', 'string', 'in:happy,okay,tired,overwhelmed'],
        ]);

        $request->user()->journalEntries()->create($validated);

        return redirect()->route('dashboard')->with('journal_saved', true);
    }

    public function destroy(JournalEntry $entry): RedirectResponse
    {
        abort_if($entry->user_id !== auth()->id(), 403);

        $entry->delete();

        return redirect()->route('dashboard')->with('journal_saved', true);
    }
}
