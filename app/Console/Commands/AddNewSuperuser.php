<?php

namespace App\Console\Commands;

use App\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

class AddNewSuperuser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'superuser:add {name} {email} {password}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Register new superuser for this system.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        User::updateOrCreate(
            [
                'email' => $this->argument('email'),
            ],
            [
                'name'        => $this->argument('name'),
                'password'    => Hash::make($this->argument('password')),
                'permissions' => ['ROLE_ADMIN'],
            ]
        );

        $this->info('New superuser was successfully created/updated!');
    }
}
