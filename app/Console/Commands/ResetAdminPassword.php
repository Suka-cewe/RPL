<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

class ResetAdminPassword extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'admin:reset-password {email?} {password?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Reset or create admin account password';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $email = $this->argument('email') ?? 'admin@libzone.com';
        $password = $this->argument('password') ?? 'admin123';

        // Find admin or create
        $admin = User::where('email', $email)->first();

        if ($admin) {
            $admin->password = Hash::make($password);
            $admin->save();
            $this->info("Admin password reset successfully for {$email}");
        } else {
            User::create([
                'name' => 'Admin',
                'email' => $email,
                'password' => Hash::make($password),
                'role' => 'admin',
            ]);
            $this->info("Admin account created with email {$email}");
        }

        $this->info("Password: {$password}");
    }
}
