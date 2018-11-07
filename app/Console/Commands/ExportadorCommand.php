<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use TCG\Voyager\Models\DataType;
use TCG\Voyager\Models\DataRow;
use TCG\Voyager\Models\MenuItem;
use Storage;

class ExportadorCommand extends Command
{

    private $filename;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'xerintel:export {tabla}';

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
     */
    public function handle()
    {
        $table = $this->argument('tabla');

        $data = DataType::whereName($table)->first();
        if (!$data) {
            $this->error('La tabla indicada no existe. Abortando');
            return;
        }

        echo 'Comenzando Exportación.' . PHP_EOL;
        $this->filename = ucfirst($table) . 'ModuleSeeder';

        $rows = DataRow::where('data_type_id', $data->id)->get();
        //$perms = Permission::generateFor($table);//para importar
        $menu = MenuItem::where('route', 'voyager.' . $table . '.index')->first();

        $query = DB::select('SHOW CREATE TABLE ' . $table);
        $query = $query[0]->{'Create Table'};
        $fichero = $this->fileStart();
        $fichero .= $this->ObjectToSeed('$data', $data);
        $fichero .= $this->ArrayToSeed('$rows', $rows);
        $fichero .= $this->ObjectToSeed('$menu', $menu);
        $fichero .= '$query' . '=' . var_export($query, true) . ";\n";
        $fichero .= $this->fileEnd();


        $storage = Storage::createLocalDriver(['root' => base_path() . '/database/seeds/']);

        $storage->put($this->filename . '.php', $fichero);
        echo 'Exportación finalizada.' . PHP_EOL;
    }


    private function ObjectToSeed($variable_name, $fields)
    {
        $fields = $this->limpiaCampos($fields);
        return $variable_name . '=' . var_export($fields->getAttributes(), true) . ";\n";
    }

    private function ArrayToSeed($variable_name, $fields)
    {
        for ($i = 0; $i < $fields->count(); $i++) {
            $fields[$i] = $this->limpiaCampos($fields[$i]);
            $fields[$i]['details'] = $fields[$i]->getOriginal('details');
        }
        return $variable_name . '=' . var_export($fields->toArray(), true) . ";\n";
    }

    private function limpiaCampos($data)
    {
        unset($data->created_at);
        unset($data->updated_at);
        unset($data->id);

        return $data;
    }

    private function fileStart()
    {
        return "<?php\n" .
            "\n" .
            "use Illuminate\Support\Facades\DB;\n" .
            "use Illuminate\Database\Seeder;\n" .
            "use TCG\Voyager\Models\DataType;\n" .
            "use TCG\Voyager\Models\DataRow;\n" .
            "use TCG\Voyager\Models\Permission;\n" .
            "use TCG\Voyager\Models\MenuItem;\n" .
            "\n" .
            "class " . $this->filename . " extends Seeder\n" .
            "{\n" .
            "    /**\n" .
            "     * Run the database seeds.\n" .
            "     *\n" .
            "     * @return void\n" .
            "     */\n" .
            "    public function run()\n" .
            "    {\n";
    }

    private function fileEnd()
    {
        return '//****Código****//' . PHP_EOL .
            '' . PHP_EOL .
            '        $table = $data[\'name\'];' . PHP_EOL .
            '        if (Schema::hasTable($table) || DataType::whereName($table)->first()) {' . PHP_EOL .
            '            echo(\'ERROR - La tabla \' . $table . \' ya existe y/o tiene un BREAD asociado. Abortando\');' . PHP_EOL .
            '            return;' . PHP_EOL .
            '        }' . PHP_EOL .
            '        DB::statement($query);' . PHP_EOL .
            '        $newData = new DataType();' . PHP_EOL .
            '        $newData->fill($data)->save();' . PHP_EOL .
            '' . PHP_EOL .
            '        foreach ($rows as $row) {' . PHP_EOL .
            '            var_dump($row);' . PHP_EOL .
            '            $row[\'data_type_id\'] = $newData->id;' . PHP_EOL .
            '            $newRow = new DataRow();' . PHP_EOL .
            '            $newRow->fill($row);' . PHP_EOL .
            '            $newRow->details = json_decode($row[\'details\']);' . PHP_EOL .
            '            $newRow->save();' . PHP_EOL .
            '        }' . PHP_EOL .
            '' . PHP_EOL .
            '        $newMenu = new MenuItem();' . PHP_EOL .
            '        $newMenu->fill($menu);' . PHP_EOL .
            '        unset($newMenu->parent_id);' . PHP_EOL .
            '        $newMenu->order = MenuItem::orderBy(\'order\', \'desc\')->first()->order + 1;' . PHP_EOL .
            '        $newMenu->save();' . PHP_EOL .
            '' . PHP_EOL .
            '        if ($newData->generate_permissions) {' . PHP_EOL .
            '            Permission::generateFor($table);' . PHP_EOL .
            '            $role = Voyager::model(\'Role\')->where(\'name\', \'admin\')->first();' . PHP_EOL .
            '' . PHP_EOL .
            '            // Get all permissions' . PHP_EOL .
            '            $permissions = Voyager::model(\'Permission\')->all();' . PHP_EOL .
            '' . PHP_EOL .
            '            // Assign all permissions to the admin role' . PHP_EOL .
            '            $role->permissions()->sync(' . PHP_EOL .
            '                $permissions->pluck(\'id\')->all()' . PHP_EOL .
            '            );' . PHP_EOL .
            '        }' . PHP_EOL .
            ' ' . PHP_EOL .
            '        echo \'Fin de la importación de \' . $table;' . PHP_EOL .
            '    }' . PHP_EOL .
            '}';
    }
}
