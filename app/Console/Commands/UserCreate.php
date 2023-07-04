<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class UserCreate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'create:user {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new user';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $json = [];
        $path = 'json/users/';
        $filename = $this->argument('name') . '.json';

        $userAge = $this->ask('How old are you?');

        if ($userAge < 18 && !$this->confirm('Do you wish to continue?')) {
            $this->error('Operation aborted.');
            return;
        }

        $option = $this->choice('Choose next options:', ['read', 'write']);

        if ($option === 'read' && file_exists(public_path($path . $filename))) {
            $file = file_get_contents(public_path($path . $filename));
            $this->info($file);
            return;
        }

        if ($option === 'write') {
            $json['name'] = $this->argument('name');
            $json['age'] = $userAge;

            $json['gender']     = $this->choice('Choose your gender:', ['Male', 'Female', 'Other']);
            $json['city']       = $this->ask('Type a name of your city?');
            $json['phone']      = $this->ask('What is your phone number?');

            file_put_contents(public_path($path . $json['name'] . '.json'), json_encode($json));
            $this->info('User has been created.');
            return;
        }

        $this->alert('Something went wrong.');
    }
}
