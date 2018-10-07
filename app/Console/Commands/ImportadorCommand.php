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
    protected $description = 'Command description';

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
     * @return mixed
     */
    public function handle()
    {
        $tabla = ucfirst($this->argument('tabla'));
        $argument = $tabla . 'ModuleSeeder';
        $this->call('db:seed', ['--class' => $argument]);
    }
}
