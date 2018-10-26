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
    protected $signature = 'xerintel:pull {full?}';

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
        if ($this->argument('full')) {
            echo 'Ejecutando version completa. Esto tomará mas tiempo.' . PHP_EOL;
        } else {
            echo 'Ejecutando version rápida. Usa el argumento "full" para la versión completa.' . PHP_EOL;
        }
        $this->runProcess(array('git', 'pull'));

        if ($this->argument('full')) {
            $this->runProcess(array('composer', 'install'));
        }


    }

    private function runProcess($commandArray)
    {
        $process = new Process($commandArray);
        $process->run(function ($type, $buffer) {
            if (Process::ERR === $type) {
                echo 'ERR > ' . $buffer;
            } else {
                echo 'OUT > ' . $buffer;
            }
        });
    }


}
