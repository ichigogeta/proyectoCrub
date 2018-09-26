<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Facades\Artisan;
use Intervention\Image\ImageServiceProviderLaravel5;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Process\Process;
use TCG\Voyager\Providers\VoyagerDummyServiceProvider;
use TCG\Voyager\Traits\Seedable;
use TCG\Voyager\VoyagerServiceProvider;
use Illuminate\Support\Facades\Hash;
use TCG\Voyager\Facades\Voyager;

class Instalador extends Command
{
    use Seedable;
    protected $seedersPath = __DIR__ . '/../../publishable/database/seeds/';

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'xerintel:install';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Instalacion simplificada marca Xerintel';

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
     * Get the composer command for the environment.
     *
     * @return string
     */
    protected function findComposer()
    {
        if (file_exists(getcwd() . '/composer.phar')) {
            return '"' . PHP_BINARY . '" ' . getcwd() . '/composer.phar';
        }

        return 'composer';
    }

    public function fire(Filesystem $filesystem)
    {
        return $this->handle($filesystem);
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle(Filesystem $filesystem)
    {
        if (!env('APP_KEY')) {
            Artisan::call('key:generate');
        }

        $this->intall($filesystem);
        $this->createAdmin();

        $this->info('Successfully installed Voyager! Enjoy');
        echo('Finalizado');
    }


    /**
     * Execute the console command.
     *
     * @param \Illuminate\Filesystem\Filesystem $filesystem
     *
     * @return void
     */
    private function intall(Filesystem $filesystem)
    {
        $this->info('Publishing the Voyager assets, database, and config files');

        // Publish only relevant resources on install
        $tags = ['voyager_assets', 'seeds'];

        $this->call('vendor:publish', ['--provider' => VoyagerServiceProvider::class, '--tag' => $tags]);
        $this->call('vendor:publish', ['--provider' => ImageServiceProviderLaravel5::class]);

        $this->info('Migrating the database tables into your application');
        $this->call('migrate');

        $this->info('Attempting to set Voyager User model as parent to App\User');
        if (file_exists(app_path('User.php'))) {
            $str = file_get_contents(app_path('User.php'));

            if ($str !== false) {
                $str = str_replace('extends Authenticatable', "extends \TCG\Voyager\Models\User", $str);

                file_put_contents(app_path('User.php'), $str);
            }
        } else {
            $this->warn('Unable to locate "app/User.php".  Did you move this file?');
            $this->warn('You will need to update this manually.  Change "extends Authenticatable" to "extends \TCG\Voyager\Models\User" in your User model');
        }

        $this->info('Dumping the autoloaded files and reloading all new files');

        $composer = $this->findComposer();

        $process = new Process($composer . ' dump-autoload');
        $process->setTimeout(null); // Setting timeout to null to prevent installation from stopping at a certain point in time
        $process->setWorkingDirectory(base_path())->run();

        $this->info('Seeding data into the database');
        $this->seed('VoyagerDatabaseSeeder');

        $this->info('Adding Voyager routes to routes/web.php');
        $routes_contents = $filesystem->get(base_path('routes/web.php'));
        if (false === strpos($routes_contents, 'Voyager::routes()')) {
            $filesystem->append(
                base_path('routes/web.php'),
                "\n\nRoute::group(['prefix' => 'admin'], function () {\n    Voyager::routes();\n});\n"
            );
        }

        \Route::group(['prefix' => 'admin'], function () {
            \Voyager::routes();
        });

        $this->info('Creando tablas por defecto');
        // if ($this->option('with-dummy')) {
        $this->info('Publishing dummy content');
        //$tags = ['dummy_seeds', 'dummy_content', 'dummy_config', 'dummy_migrations'];
        //$tags = ['dummy_migrations'];
        $tags = ['dummy_seeds', 'dummy_content', 'dummy_migrations'];
        $this->call('vendor:publish', ['--provider' => VoyagerDummyServiceProvider::class, '--tag' => $tags]);

        $this->info('Migrating dummy tables');
        $this->call('migrate');

        $this->info('Seeding dummy data');
        $this->seed('VoyagerDummyDatabaseSeeder');


        $this->call('vendor:publish', ['--provider' => VoyagerServiceProvider::class, '--tag' => 'config']);


        $this->info('Setting up the hooks');
        $this->call('hook:setup');

        $this->info('Adding the storage symlink to your public folder');
        $this->call('storage:link');

    }

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function createAdmin()
    {
        // Get or create user
        $user = $this->getUser(true);

        // the user not returned
        if (!$user) {
            $this->info('¿Es posible que el usuario ya existiera?');
            $this->info('Cancelada creación de usuario');
            exit;
        }

        // Get or create role
        $role = $this->getAdministratorRole();

        // Get all permissions
        $permissions = Voyager::model('Permission')->all();

        // Assign all permissions to the admin role
        $role->permissions()->sync(
            $permissions->pluck('id')->all()
        );

        // Ensure that the user is admin
        $user->role_id = $role->id;
        $user->save();

        $this->info('The user now has full access to your site.');
    }

    /**
     * Get the administrator role, create it if it does not exists.
     *
     * @return mixed
     */
    protected function getAdministratorRole()
    {
        $role = Voyager::model('Role')->firstOrNew([
            'name' => 'admin',
        ]);

        if (!$role->exists) {
            $role->fill([
                'display_name' => 'Administrator',
            ])->save();
        }

        return $role;
    }

    /**
     * Get or create user.
     *
     * @param bool $create
     *
     * @return \App\User
     */
    protected function getUser($create = false)
    {
        //$email = $this->argument('email');
        $email = "admin@admin.com";

        $model = config('voyager.user.namespace') ?: config('auth.providers.users.model');

        if ($model::where('email', $email)->first())
            return false;

        // If we need to create a new user go ahead and create it
        if ($create) {
            $name = 'Xerintel';//$this->ask('Enter the admin name');
            $password = $this->secret('Escribe contraseña del usuario admin');
            $confirmPassword = $this->secret('Confirma la contraseña anterior');

            // Ask for email if there wasnt set one
            if (!$email) {
                $email = $this->ask('Enter the admin email');
            }

            // Passwords don't match
            if ($password != $confirmPassword) {
                $this->info("Passwords don't match");

                return;
            }

            $this->info('Creating admin account');

            return $model::create([
                'name' => $name,
                'email' => $email,
                'password' => Hash::make($password),
            ]);
        }

        return $model::where('email', $email)->firstOrFail();
    }


}
