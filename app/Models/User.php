<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Models\JournalEntry;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'parent_type',
        'child_date',
        'arrival_snoozed_until',
    ];

    public const PARENT_TYPES = ['expecting', 'new_parent', 'working_parent', 'solo_parent'];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'child_date' => 'date',
            'arrival_snoozed_until' => 'date',
        ];
    }

    public function journalEntries()
    {
        return $this->hasMany(JournalEntry::class);
    }

    public function milestoneChecks()
    {
        return $this->hasMany(MilestoneCheck::class);
    }

    public function waitlistSignup()
    {
        return $this->hasOne(WaitlistSignup::class);
    }

    public function isExpecting(): bool
    {
        return $this->parent_type === 'expecting';
    }

    /** Completed weeks of pregnancy (1–40), or null without a due date. */
    public function pregnancyWeek(): ?int
    {
        if (! $this->isExpecting() || ! $this->child_date) {
            return null;
        }

        $daysUntilDue = (int) today()->diffInDays($this->child_date, false);

        return max(1, min(40, intdiv(280 - $daysUntilDue, 7)));
    }

    /** True once an expecting parent's due date has arrived, unless they snoozed the prompt. */
    public function shouldPromptArrival(): bool
    {
        return $this->isExpecting()
            && $this->child_date
            && $this->child_date->lte(today())
            && (! $this->arrival_snoozed_until || $this->arrival_snoozed_until->lte(today()));
    }
}
