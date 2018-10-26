<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Process\Process;

class GitPullCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'xerintel:pull {--composer} {--force}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Realiza git pull';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }


    public function handle()
    {
        if ($this->option('force')) {
            echo('Pull Sobreescribiendo cambios no guardados e ignorados' . PHP_EOL);
            $this->runProcess(array('git', 'fetch', 'origin', 'master'));
            $this->runProcess(array('git', 'reset', '--hard', 'origin/master'));
        } else {
            $this->runProcess(array('git', 'pull'));
        }


        if ($this->option('full')) {

            echo 'Ejecutando composer install. Esto tomará un tiempo.' . PHP_EOL;

            $this->runProcess(array('composer', 'install'), null);

        } else {
            echo 'Ejecutada version rápida. Usa el argumento "--full" para la versión completa.' . PHP_EOL;

        }

    }

    private function runProcess($commandArray, $timeout = 300)
    {
        $process = new Process($commandArray);
        $process->setTimeout($timeout);
        $process->run(function ($type, $buffer) {
            if (Process::ERR === $type) {
                echo 'ERR > ' . $buffer;
            } else {
                echo 'OUT > ' . $buffer;
            }
        });
    }


}
