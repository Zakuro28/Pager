<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/** Sets up a clean, ready-to-use account for one usability-test participant. */
class CreateParticipant extends Command
{
    protected $signature = 'pager:participant
                            {code : Participant code, e.g. P1}
                            {--type=new_parent : expecting, new_parent, working_parent or solo_parent}';

    protected $description = 'Create (or reset) a verified test account for a usability session';

    public function handle(): int
    {
        $type = $this->option('type');

        if (! in_array($type, User::PARENT_TYPES, true)) {
            $this->error('Unknown --type. Use one of: ' . implode(', ', User::PARENT_TYPES));

            return self::FAILURE;
        }

        $code     = Str::lower($this->argument('code'));
        $email    = "{$code}@test.pager";
        $password = "pager-{$code}";

        // Start from a clean slate so no one sees the previous session's entries.
        User::where('email', $email)->first()?->delete();

        $user = User::create([
            'name'        => 'Participant ' . Str::upper($code),
            'email'       => $email,
            'password'    => Hash::make($password),
            'parent_type' => $type,
            // Expecting participants are 28 weeks along, so the pregnancy view has content.
            'child_date'  => $type === 'expecting' ? today()->addWeeks(12) : null,
        ]);
        $user->forceFill(['email_verified_at' => now()])->save();

        $this->info('Participant account ready:');
        $this->line("  Email:    {$email}");
        $this->line("  Password: {$password}");
        $this->line("  Stage:    {$type}");

        return self::SUCCESS;
    }
}
