<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Intervention\Image\ImageServiceProviderLaravel5;
use TCG\Voyager\VoyagerServiceProvider;

class RepairCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'xerintel:repair';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Reinstalación simplificada marca Xerintel';

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
        $this->info('Comenzando reparación de assets');
        if (!config('app.key')) {
            Artisan::call('key:generate');
        }

        $this->install();

        $this->info('Finalizada reparación');
    }


    /**
     * Execute the console command.
     *
     * @return void
     */
    private function install()
    {
        $this->info('Publishing the Voyager assets, database, and config files');

        // Publish only relevant resources on install
        $tags = ['voyager_assets'];

        $this->call('vendor:publish', ['--provider' => VoyagerServiceProvider::class, '--tag' => $tags]);
        $this->call('vendor:publish', ['--provider' => ImageServiceProviderLaravel5::class]);

        $this->info('Setting up the hooks');
        $this->call('hook:setup');

        $this->info('Adding the storage symlink to your public folder');
        $this->call('storage:link');

    }

}
