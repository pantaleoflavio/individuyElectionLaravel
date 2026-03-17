<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Str;

class SetSuperAdmin extends Command
{
 /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:set-super-admin {--email=} {--password=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Promote a user to super_admin by email or create it';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $email = config('app.superadmin_email');
        $password = config('app.superadmin_password');

        if (! $email || ! $password) {
            $this->error('Missing super admin credentials. Set SUPERADMIN_EMAIL and SUPERADMIN_PASSWORD.');
            return self::FAILURE;
        }

        $user = User::where('email', $email)->first();

        if ($user) {
            if ($user->role === 'super_admin') {
                $this->info("User {$email} is already a super admin.");
                return self::SUCCESS;
            }

            $user->forceFill(['role' => 'super_admin'])->save();
            $this->info("User {$email} has been promoted to super admin.");
            return self::SUCCESS;
        }

        $username = Str::before($email, '@');

        User::create([
            'name' => 'Super Admin',
            'username' => $username,
            'email' => $email,
            'password' => $password,
            'role' => 'super_admin',
        ]);

        $this->info("Super admin created with email {$email}.");

        return self::SUCCESS;
    }
}
