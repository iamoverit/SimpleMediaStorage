<?php

namespace App\Console\Commands;

use App\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\MessageBag;

class RegisterAdminCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'register:admin';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Register admin';

    /**
     * User model.
     *
     * @var object
     */
    private $user;

    /**
     * Create a new command instance.
     *
     * @param User $user
     */
    public function __construct(User $user)
    {
        parent::__construct();

        $this->user = $user;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $data = $this->getData();
        $admin = $this->create($data);
        $this->display($admin);
    }

    /**
     * Ask for admin details.
     *
     * @return array
     */
    private function getData(): array
    {
        $errors = new MessageBag();
        do {
            foreach($errors->getMessages() as $message) {
                $this->info($message[0]);
            }
            $details['name'] = $this->ask('Name');
            $details['email'] = $this->ask('Email');
            $details['password'] = $this->secret('Password');
            $details['password_confirmation'] = $this->secret('Confirm password');
            $errors = $this->validator($details)->errors();
        } while ($errors->isNotEmpty());

        return $details;
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param array $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make(
            $data,
            [
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
                'password' => ['required', 'string', 'min:8', 'confirmed'],
            ]
        );
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param array $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);
    }

    /**
     * Display created admin.
     *
     * @param array $admin
     * @return void
     */
    private function display(User $admin) : void
    {
        $headers = ['Name', 'Email', 'Super admin'];
        $fields = [
            'Name' => $admin->name,
            'email' => $admin->email,
        ];
        $this->info('Super admin created');
        $this->table($headers, [$fields]);
    }
}
