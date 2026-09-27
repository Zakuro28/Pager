{{-- Journal entries as a month-by-month timeline. Rendered inside the dashboard and on its own by GET /journal. --}}
@php
    $moodEmoji = ['happy' => '😊', 'okay' => '😌', 'tired' => '😴', 'overwhelmed' => '😰'];
    $filtering = $filters['q'] !== '' || $filters['mood'] || $filters['tag'];
    // Split on the search term first, then escape each piece, so matches can't break HTML entities.
    $highlight = function (string $text) use ($filters) {
        if ($filters['q'] === '') {
            return e($text);
        }
        $parts = preg_split('/(' . preg_quote($filters['q'], '/') . ')/iu', $text, -1, PREG_SPLIT_DELIM_CAPTURE);
        return collect($parts)->map(fn ($part, $i) => $i % 2 ? '<mark>' . e($part) . '</mark>' : e($part))->implode('');
    };
@endphp

@if ($filtering)
    <div class="entries-hd" aria-live="polite">
        {{ $entries->total() }} {{ Str::plural('entry', $entries->total()) }} found
        <a href="{{ route('dashboard') }}#journal" class="clear-filters" data-clear>Clear</a>
    </div>
@elseif ($entries->total())
    <div class="entries-hd">Your timeline</div>
@endif

@forelse ($entries->getCollection()->groupBy(fn ($entry) => $entry->created_at->format('Y-m')) as $month => $monthEntries)
    <section class="tl-month" data-month="{{ $month }}">
        <h4 class="tl-month-label">{{ $monthEntries->first()->created_at->format('F Y') }}</h4>
        <div class="tl-items">
            @foreach ($monthEntries as $entry)
                <article class="entry" data-entry data-mood="{{ $entry->mood }}">
                    <span class="tl-dot" aria-hidden="true"></span>
                    <div class="entry-meta">
                        <div class="entry-info">
                            <time datetime="{{ $entry->created_at->toIso8601String() }}">{{ $entry->created_at->format('D, M j · g:i A') }}</time>
                            @if ($entry->mood)
                                <span class="entry-mood">{{ $moodEmoji[$entry->mood] ?? '' }} {{ ucfirst($entry->mood) }}</span>
                            @endif
                        </div>
                        <form method="POST" action="{{ route('journal.destroy', $entry) }}" class="delete-form">
                            @csrf @method('DELETE')
                            <button class="btn-del" type="submit" title="Delete entry" aria-label="Delete entry"><x-icon name="trash-2" :size="14" /><span class="btn-del-text">Delete?</span></button>
                        </form>
                    </div>
                    <div class="entry-text">{!! $highlight($entry->content) !!}</div>
                    @if ($entry->tags && count($entry->tags))
                        <div class="entry-tags">
                            @foreach ($entry->tags as $t)
                                <a class="entry-tag" href="{{ route('dashboard', ['tag' => $t]) }}#journal" data-tag="{{ $t }}" title="Show entries tagged {{ $t }}">#{{ $t }}</a>
                            @endforeach
                        </div>
                    @endif
                </article>
            @endforeach
        </div>
    </section>
@empty
    @if ($filtering)
        <div class="empty">
            <div class="empty-icon"><x-icon name="search" :size="28" /></div>
            <strong class="empty-title">No entries match.</strong>
            <span>Try another word, or <a href="{{ route('dashboard') }}#journal" data-clear>clear the filters</a>.</span>
        </div>
    @else
        @php
            $prompts = [
                'expecting'      => ['How are you feeling about the birth?', 'What are you most looking forward to?', 'Something your body did this week that surprised you'],
                'working_parent' => ['What made you smile today?', 'A moment with your child you want to remember', 'What was hardest about balancing today?'],
                'solo_parent'    => ['What made you smile today?', 'Something you handled well this week', 'Who helped you out recently?'],
            ][auth()->user()->parent_type] ?? ['What made you smile today?', 'One thing your baby did for the first time', "What's worrying you right now?"];
        @endphp
        <div class="empty">
            <div class="empty-icon"><x-icon name="notebook-pen" :size="32" /></div>
            <strong class="empty-title">Your first entry starts here.</strong>
            <span>Not sure what to write? Try one:</span>
            <div class="prompt-row">
                @foreach ($prompts as $prompt)
                    <button type="button" class="prompt-chip">{{ $prompt }}</button>
                @endforeach
            </div>
        </div>
    @endif
@endforelse

@if ($entries->hasMorePages())
    <a class="btn-more" href="{{ $entries->nextPageUrl() }}" data-more>Show older entries</a>
@endif
