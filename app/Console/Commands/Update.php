<?php

namespace App\Console\Commands;

use Artisan;
use Illuminate\Console\Command;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;

class Update extends Command
{
    /**
     * @var string
     */
    protected $name = 'kosher:update';

    /**
     * @var string
     */
    protected $description = 'Easy way to update the project';

    /**
     * Run console commands
     */
    public function handle()
    {
        $this->runProcess('git checkout .');
        $this->runProcess('git pull');
        $this->runProcess('composer install');
        $this->runProcess('composer dump-autoload');
        Artisan::call('migrate');
        Artisan::call('db:seed');
        $this->runProcess('npm prune');
        $this->runProcess('npm install');
        $this->runProcess('npm run prod');
        Artisan::call('cache:clear');
        Artisan::call('config:clear');
        Artisan::call('view:clear');
        $this->info('The project is updated');
    }

    /**
     * @param string $cmd
     */
    private function runProcess($cmd)
    {
        $process = new Process($cmd);
        $process->run();
        if (!$process->isSuccessful()) {
            throw new ProcessFailedException($process);
        }
    }
}
