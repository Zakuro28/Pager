<?php

namespace App\Support;

use Carbon\CarbonInterface;

/**
 * One parenting quote per day, the same for every user, rotating through a curated list.
 */
class DailyQuote
{
    private const QUOTES = [
        ['The days are long, but the years are short.', 'Gretchen Rubin'],
        ['Anyone who does anything to help a child in his life is a hero to me.', 'Fred Rogers'],
        ['The way we talk to our children becomes their inner voice.', "Peggy O'Mara"],
        ['Play is the work of the child.', 'Maria Montessori'],
        ['There is no such thing as a perfect parent. So just be a real one.', 'Sue Atkins'],
        ['Children learn more from what you are than what you teach.', 'W. E. B. Du Bois'],
        ['It takes a village to raise a child.', 'African proverb'],
        ['You are the bows from which your children as living arrows are sent forth.', 'Kahlil Gibran'],
        ['Caring for myself is not self-indulgence, it is self-preservation.', 'Audre Lorde'],
        ['Every child begins the world again, to some extent.', 'Henry David Thoreau'],
        ['Children are not things to be molded, but are people to be unfolded.', 'Jess Lair'],
        ['Your children need your presence more than your presents.', 'Jesse Jackson'],
    ];

    /** @return array{text: string, author: string} */
    public static function for(CarbonInterface $date): array
    {
        [$text, $author] = self::QUOTES[intdiv($date->copy()->startOfDay()->timestamp, 86400) % count(self::QUOTES)];

        return ['text' => $text, 'author' => $author];
    }
}
