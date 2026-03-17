<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class BootstrapApp extends Command
{
    protected $signature = 'app:bootstrap';
    protected $description = 'Bootstrap application (migrate, seed, admin, etc.)';

    public function handle(): int
    {
        $this->info('Starting app bootstrap...');

        // Clear cache
        $this->info('Clearing cache...');
        Artisan::call('optimize:clear');
        $this->line(Artisan::output());

        // Migrate
        $this->info('Running migrations...');
        Artisan::call('migrate', ['--force' => true]);
        $this->line(Artisan::output());

        // Seed
        $this->info('Running seeders...');
        Artisan::call('db:seed', ['--force' => true]);
        $this->line(Artisan::output());

        // Superadmin
        if ($email = env('SUPERADMIN_EMAIL')) {
            $this->info("Ensuring superadmin: {$email}");
            Artisan::call('app:set-superadmin', [
                'email' => $email,
            ]);
            $this->line(Artisan::output());
        }

        // Ranking averages
        $this->info('Rebuilding ranking averages...');
        Artisan::call('app:calculate-all-ranking-averages');
        $this->line(Artisan::output());

        $this->info('Bootstrap completed.');

        return self::SUCCESS;
    }
}
