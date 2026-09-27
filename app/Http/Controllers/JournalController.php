<?php

namespace App\Http\Controllers;

use App\Models\JournalEntry;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class JournalController extends Controller
{
    public const PER_PAGE = 10;

    /** The entries list on its own, so the dashboard can search and load more without a reload. */
    public function index(Request $request): View
    {
        $filters = JournalEntry::filtersFrom($request);

        return view('journal.entries', [
            'entries' => self::entriesFor($request, $filters),
            'filters' => $filters,
        ]);
    }

    /** Filtered, newest-first entries. Page links point at the dashboard so they also work without JavaScript. */
    public static function entriesFor(Request $request, array $filters): LengthAwarePaginator
    {
        return $request->user()->journalEntries()
            ->filter($filters)
            ->latest()
            ->paginate(self::PER_PAGE)
            ->withPath(route('dashboard'))
            ->withQueryString()
            ->fragment('journal');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'content' => ['required', 'string', 'max:2000'],
            'mood'    => ['nullable', 'string', Rule::in(JournalEntry::MOODS)],
            'tags'    => ['nullable', 'array'],
            'tags.*'  => ['string', Rule::in(JournalEntry::TAGS)],
        ]);

        $request->user()->journalEntries()->create($validated);

        return redirect()->route('dashboard')->with('journal_saved', true);
    }

    public function destroy(JournalEntry $entry): RedirectResponse
    {
        abort_if($entry->user_id !== auth()->id(), 403);

        $entry->delete();

        return redirect()->route('dashboard')->with('journal_deleted', true);
    }
}
