<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class CreateAdmin extends Command
{
    protected $signature = 'pager:create-admin
                            {email : Email of the admin (an existing user is promoted)}
                            {--name= : Name for a new account}
                            {--password= : Password for a new account (prompted if omitted)}';

    protected $description = 'Create an admin account, or promote an existing user to admin';

    public function handle(): int
    {
        $email = $this->argument('email');

        if ($user = User::where('email', $email)->first()) {
            $user->forceFill(['is_admin' => true])->save();
            $this->info("{$email} is now an admin.");

            return self::SUCCESS;
        }

        $name     = $this->option('name') ?: $this->ask('Name', 'Admin');
        $password = $this->option('password') ?: $this->secret('Password (min 8 characters)');

        $validator = Validator::make(
            ['email' => $email, 'password' => $password],
            ['email' => ['required', 'email'], 'password' => ['required', 'string', 'min:8']],
        );

        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $error) {
                $this->error($error);
            }

            return self::FAILURE;
        }

        $user = User::create([
            'name'     => $name,
            'email'    => $email,
            'password' => Hash::make($password),
        ]);
        $user->forceFill(['is_admin' => true, 'email_verified_at' => now()])->save();

        $this->info("Admin account created for {$email}.");

        return self::SUCCESS;
    }
}
