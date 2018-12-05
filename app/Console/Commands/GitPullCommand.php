<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Symfony\Component\Process\Process;

putenv("COMPOSER_HOME=" . base_path() . '/../.config/composer');
require_once base_path('vendor/composer/composer/src/Composer/Console/Application.php');
require_once base_path('vendor/composer/composer/src/Composer/Command/UpdateCommand.php');

use Composer\Console\Application;
use Composer\Command\UpdateCommand;
use Symfony\Component\Console\Input\ArrayInput;

class GitPullCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'xerintel:pull {--force} {--s|skip} {--c|composer} {--o|optimize} {--f|full}';

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
        set_time_limit(600); //10 minutos debería ser suficiente para hacerlo 2 veces

        $this->gitPull();

        $this->composerInstall();

        $this->optimizaciones();
    }

    /**
     * Ejecuta git pull o force pull si se le indicó.
     */
    private function gitPull()
    {
        if ($this->option('skip')) {
            return;
        }

        if ($this->option('force')) {
            echo('Pull Sobreescribiendo cambios no guardados e ignorados' . PHP_EOL);
            $this->runProcess(array('git', 'fetch', 'origin', 'master'));
            $this->runProcess(array('git', 'reset', '--hard', 'origin/master'));
        } else {
            $this->runProcess(array('git', 'pull'));
        }
    }

    /**
     * Solo en producción ejecutará optimizaciones
     */
    private function optimizaciones()
    {
        if ($this->option('optimize') || $this->option('full'))

            if (!config('app.debug')) {
                echo 'Comenzada la optimización' . PHP_EOL;

                Artisan::call('route:cache');
                Artisan::call('view:clear');

                echo 'Finalizada la optimización' . PHP_EOL;
            } else {
                echo 'Debug activado. No se optimizará' . PHP_EOL;
            }

    }

    /**
     * Ejecuta el comando shell indicado
     * @param $commandArray
     * @param int $timeout 300 segundos por defecto
     */
    private function runProcess($commandArray, $timeout = 300)
    {
        $process = new Process($commandArray);
        $process->setTimeout($timeout);
        $process->setWorkingDirectory(base_path());

        $process->run(function ($type, $buffer) {
            if (Process::ERR === $type) {
                echo 'ERR > ' . $buffer;
            } else {
                echo 'OUT > ' . $buffer;
            }
        });
    }

    /**
     * Composer install en producción
     */
    private function composerInstall()
    {
        if (!$this->option('composer') && !$this->option('full'))
            return;

        //Configuration
        //ini_set('memory_limit', -1);  //could be forbidden on server

        $args = array('command' => 'install',
            '--no-dev' => true,
            '--optimize-autoloader' => true,
            '--no-suggest' => true
        );

        $input = new ArrayInput($args);

        //Create the application and run it with the commands
        $application = new Application();
        $application->setAutoExit(false);
        $application->setCatchExceptions(false);

        try {
            //Running commdand php.ini allow_url_fopen=1 && proc_open() function available
            $exitCode = $application->run($input);
        } catch (\Exception $e) {
            $exitCode = 1;
            echo 'Error: ' . $e->getMessage() . "\n";
        }

        //Result message
        if ($exitCode == 0) {
            echo "Finalizado adecuadamente";
        } elseif ($exitCode == 2) {
            echo "Composer falló por problemas de dependencias";
        } else {
            echo "Composer ha fallado por un error";
        }

    }

}
