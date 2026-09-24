<?php

namespace App\Support;

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
