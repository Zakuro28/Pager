<?php

namespace App\Support;

use App\Models\User;
use Illuminate\Support\Str;

/**
 * Checklist content for the dashboard Milestones panel.
 * Expecting parents get a pregnancy checklist; everyone else gets baby milestones.
 */
class Milestones
{
    private const BABY = [
        '0–2 months' => ['Responds to sounds', 'Focuses on faces', 'Follows moving objects', 'First smile'],
        '2–4 months' => ['Holds head steady', 'Pushes up (tummy time)', 'Coos and babbles', 'Laughs out loud'],
        '4–6 months' => ['Rolls over', 'Sits with support', 'Reaches for objects', 'Recognizes familiar faces'],
        '6–9 months' => ['Sits without support', 'Says "mama" or "dada"', 'Picks up small objects', 'Crawls or scoots'],
    ];

    private const PREGNANCY = [
        'First trimester'  => ['Confirm pregnancy with a doctor', 'Start prenatal vitamins', 'First prenatal visit'],
        'Second trimester' => ['Anatomy scan', 'Plan parental leave', 'Start a baby budget'],
        'Third trimester'  => ['Glucose screening', 'Tour the hospital', 'Pack hospital bag', 'Install car seat', 'Choose a paediatrician'],
    ];

    /**
     * Groups of milestones for a parent type, each item with a stable key.
     *
     * @return array<string, list<array{key: string, label: string}>>
     */
    public static function groupsFor(?string $parentType): array
    {
        [$prefix, $source] = $parentType === 'expecting'
            ? ['preg', self::PREGNANCY]
            : ['baby', self::BABY];

        $groups = [];
        foreach ($source as $group => $labels) {
            foreach ($labels as $label) {
                $groups[$group][] = [
                    'key'   => $prefix . '-' . Str::slug($label),
                    'label' => $label,
                ];
            }
        }

        return $groups;
    }

    /** Age in months (baby) or pregnancy week at which each group starts, in the same order as the lists above. */
    private const BABY_STARTS_AT_MONTH = [0, 2, 4, 6];

    private const PREGNANCY_STARTS_AT_WEEK = [1, 14, 28];

    /**
     * What to focus on right now: the unticked items for the child's current age
     * (or current trimester), plus anything unticked from earlier stages.
     * Null when we don't know the date yet.
     *
     * @param  list<string>  $checkedKeys
     * @return array{stage: string, group: string, due: list<array{key: string, label: string}>, overdue: list<array{key: string, label: string}>, next: ?string}|null
     */
    public static function remindersFor(User $user, array $checkedKeys): ?array
    {
        if (! $user->child_date) {
            return null;
        }

        if ($user->isExpecting()) {
            $week   = $user->pregnancyWeek();
            $starts = self::PREGNANCY_STARTS_AT_WEEK;
            $value  = $week;
        } else {
            if ($user->child_date->isFuture()) {
                return null;
            }
            $months = (int) floor($user->child_date->diffInMonths(today()));
            $starts = self::BABY_STARTS_AT_MONTH;
            $value  = $months;
        }

        $groups = self::groupsFor($user->parent_type);
        $names  = array_keys($groups);

        $current = 0;
        foreach ($starts as $i => $start) {
            if ($value >= $start) {
                $current = $i;
            }
        }

        $unticked = fn (array $items) => array_values(array_filter($items, fn ($item) => ! in_array($item['key'], $checkedKeys, true)));

        $overdue = [];
        foreach (array_slice($names, 0, $current) as $name) {
            $overdue = array_merge($overdue, $unticked($groups[$name]));
        }

        $stage = $user->isExpecting()
            ? "Week {$week} · {$names[$current]}"
            : ($months === 0 ? 'Your baby is under a month old' : 'Your baby is ' . $months . ' ' . Str::plural('month', $months) . ' old');

        return [
            'stage'   => $stage,
            'group'   => $names[$current],
            'due'     => $unticked($groups[$names[$current]]),
            'overdue' => $overdue,
            'next'    => $names[$current + 1] ?? null,
        ];
    }

    /** @return list<string> */
    public static function keysFor(?string $parentType): array
    {
        return collect(self::groupsFor($parentType))->flatten(1)->pluck('key')->all();
    }

    /** Every valid key, across both checklists. */
    public static function allKeys(): array
    {
        return array_merge(self::keysFor('expecting'), self::keysFor('new_parent'));
    }
}
