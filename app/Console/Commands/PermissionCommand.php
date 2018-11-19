<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use TCG\Voyager\Models\Permission;
use TCG\Voyager\Models\Role;

class PermissionCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'xerintel:perm {name} {table?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Añade el nodo de permiso indicado';

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
        //
        if (!$this->argument('name')) {
            $this->error('Es necesario indicar el nombre del nodo a crear.');
            return;
        }

        if (Permission::where('key', $this->argument('name'))->first()) {
            $this->error('Ese nodo ya existe, no se volverá a crear');
            return;
        }


        $role = Role::where('name', 'admin')->firstOrFail();

        $myperm = new Permission();
        $myperm->key = $this->argument('name');
        $myperm->save();
        $role->permissions()->attach($myperm->id);

        echo 'Creado el nodo: ' . $this->argument('name') . PHP_EOL;
    }
}
