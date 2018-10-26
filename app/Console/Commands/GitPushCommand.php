<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Process\Process;

class GitPushCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'xerintel:push {--m=?} {--push}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Realiza git add commit y push';

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
        if ($this->option('push')) {
            echo('Omitiendo commit. Directo al push');
            $this->runProcess(array('git', 'push'));
        } else {
            if ($this->option('m') != '?')
                $commit = $this->option('m');
            else
                $commit = 'Commit remoto: ' . date('d-m-Y H:i:s');
            echo('Realizando commit y push de: ' . $commit . PHP_EOL);

            $this->runProcess(array('git', 'add', '-A'));
            $this->runProcess(array('git', 'commit', '-m', $commit));
            $this->runProcess(array('git', 'push'));


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
