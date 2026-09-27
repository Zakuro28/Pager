<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class JournalEntry extends Model
{
    use HasFactory;

    public const MOODS = ['happy', 'okay', 'tired', 'overwhelmed'];

    public const TAGS = ['milestone', 'emotion', 'health', 'routine', 'feeding', 'sleep', 'growth', 'behaviour'];

    protected $fillable = ['user_id', 'content', 'mood', 'tags'];

    protected $casts = ['tags' => 'array'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Search/filter values from the query string. Unknown moods or tags are dropped
     * rather than rejected, so a stale link just shows everything.
     *
     * @return array{q: string, mood: ?string, tag: ?string}
     */
    public static function filtersFrom(Request $request): array
    {
        $mood = $request->query('mood');
        $tag  = $request->query('tag');

        return [
            'q'    => mb_substr(trim((string) $request->query('q', '')), 0, 100),
            'mood' => in_array($mood, self::MOODS, true) ? $mood : null,
            'tag'  => in_array($tag, self::TAGS, true) ? $tag : null,
        ];
    }

    public function scopeFilter(Builder $query, array $filters): Builder
    {
        return $query
            ->when($filters['q'] ?? '', fn (Builder $q, string $term) => $q->whereRaw('LOWER(content) LIKE ?', ['%' . mb_strtolower($term) . '%']))
            ->when($filters['mood'] ?? null, fn (Builder $q, string $mood) => $q->where('mood', $mood))
            ->when($filters['tag'] ?? null, fn (Builder $q, string $tag) => $q->whereJsonContains('tags', $tag));
    }
}
