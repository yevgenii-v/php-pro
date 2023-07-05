<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class CreateUser extends Command
{
    protected string|array $option;
    protected string $path;
    protected string $filename;

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
        $this->path = 'json/users/';
        $this->filename = $this->argument('name') . '.json';

        $userAge = $this->ask('How old are you?');

        if ($this->isLegalAge($userAge)) {
            $this->error('Operation aborted.');
            return;
        }

        $this->option = $this->choice('Choose next options:', ['read', 'write']);

        if ($this->optionRead()) {
            $file = file_get_contents(public_path($this->path . $this->filename));
            $this->info($file);
            return;
        }

        if ($this->option === 'write') {
            $json['name'] = $this->argument('name');
            $json['age'] = $userAge;

            $json['gender']     = $this->choice('Choose your gender:', ['Male', 'Female', 'Other']);
            $json['city']       = $this->ask('Type a name of your city?');
            $json['phone']      = $this->ask('What is your phone number?');

            file_put_contents(public_path($this->path . $this->filename), json_encode($json));
            $this->info('User has been created.');
            return;
        }

        $this->alert('Something went wrong.');
    }

    private function isLegalAge(int $userAge): bool
    {
        return $userAge < 18 && $this->confirm('Do you wish to continue?') === false;
    }

    private function optionRead(): bool
    {
        return $this->option === 'read' && file_exists(public_path($this->path . $this->filename)) === true;
    }
}
