<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class ImportadorCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'xerintel:import {tabla}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Importador de Breads desde fichero';

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
     */
    public function handle()
    {
        echo 'Comenzando importación' . PHP_EOL;

        $tabla = ucfirst($this->argument('tabla'));
        $argument = $tabla . 'ModuleSeeder';
        $this->call('db:seed', ['--class' => $argument]);

        echo 'Fin del script de importación' . PHP_EOL;
    }
}
