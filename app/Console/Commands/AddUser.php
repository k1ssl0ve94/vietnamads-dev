<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Repositories\UserRepository;

class AddUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:add {email} {password}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Add User';

    protected $userRepo;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(UserRepository $userRepo)
    {
        parent::__construct();

        $this->userRepo = $userRepo;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->line($this->description);
        $email = $this->argument('email');
        $password = $this->argument('password');

        $user = $this->userRepo->getByEmail($email);
        if ($user) {
            $this->error('email already existed!');
            return;
        }

        $data = [
            'email' => $email,
            'password' => $password,
            'name' => 'Name',
            'status' => config('user.status.active'),
        ];

        if ($user = $this->userRepo->add($data, [])) {
            $this->info('Add user success');
        } else {
            $this->error('Add user failed');
        }
    }
}
