<?php
/**
 * Created by PhpStorm.
 * User: jaak
 * Date: 2019-09-10
 * Time: 22:40.
 */

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Container\Container;
use Illuminate\Filesystem\Filesystem;
use Exception;
use Illuminate\Support\Str;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class MigrationMakeCommand extends Command
{
    /**
     * The console command name.
     * https://github.com/laracasts/Laravel-5-Generators-Extended.
     *
     * @var string
     *             php artisan make:migration:schema create_posts_table --schema="user_id:unsignedInteger:foreign, title:string, body:text"
     */
    protected $name = 'make:migration:schema';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new migration class and apply schema at the same time';

    /**
     * The filesystem instance.
     *
     * @var Filesystem
     */
    protected $files;

    /**
     * Meta information for the requested migration.
     *
     * @var array
     */
    protected $meta;

    /**
     * @var Composer
     */
    private $composer;

    /**
     * Create a new command instance.
     *
     * @param Filesystem $files
     * @param Composer   $composer
     */
    public function __construct(Filesystem $files)
    {
        parent::__construct();

        $this->files = $files;
        $this->composer = app()['composer'];
    }

    /**
     * Alias for the fire method.
     *
     * In Laravel 5.5 the fire() method has been renamed to handle().
     * This alias provides support for both Laravel 5.4 and 5.5.
     */
    public function handle()
    {
        $this->fire();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function fire()
    {
        $this->meta = $this->nameParse($this->argument('name'));

        $this->makeMigration();
        $this->call('curd:generator', [
            'name' => $this->getModelName(),
        ]);
//        $this->makeModel();
    }

    /**
     * Get the application namespace.
     *
     * @return string
     */
    protected function getAppNamespace()
    {
        return Container::getInstance()->getNamespace();
    }

    /**
     * Generate the desired migration.
     */
    protected function makeMigration()
    {
        $name = $this->argument('name');

        if ($this->files->exists($path = $this->getPath($name))) {
            return $this->error($this->type.' already exists!');
        }

        $this->makeDirectory($path);

        $this->files->put($path, $this->compileMigrationStub());

        $this->info('Migration created successfully.');

        $this->composer->dumpAutoloads();
    }

    /**
     * Generate an Eloquent model, if the user wishes.
     */
    protected function makeModel()
    {
        $modelPath = $this->getModelPath($this->getModelName());

        if ($this->option('model') && !$this->files->exists($modelPath)) {
            $this->call('make:model', [
                'name' => $this->getModelName(),
            ]);
        }
    }

    /**
     * Build the directory for the class if necessary.
     *
     * @param string $path
     *
     * @return string
     */
    protected function makeDirectory($path)
    {
        if (!$this->files->isDirectory(dirname($path))) {
            $this->files->makeDirectory(dirname($path), 0777, true, true);
        }
    }

    /**
     * Get the path to where we should store the migration.
     *
     * @param string $name
     *
     * @return string
     */
    protected function getPath($name)
    {
        return base_path().'/database/migrations/'.date('Y_m_d_His').'_'.$name.'.php';
    }

    /**
     * Get the destination class path.
     *
     * @param string $name
     *
     * @return string
     */
    protected function getModelPath($name)
    {
        $name = str_replace($this->getAppNamespace(), '', $name);

        return $this->laravel['path'].'/'.str_replace('\\', '/', $name).'.php';
    }

    /**
     * Compile the migration stub.
     *
     * @return string
     */
    protected function compileMigrationStub()
    {
        $stub = $this->files->get(resource_path('stubs/migration.stub'));

        $this->replaceClassName($stub)
            ->replaceSchema($stub)
            ->replaceTableName($stub);

        return $stub;
    }

    /**
     * Replace the class name in the stub.
     *
     * @param string $stub
     *
     * @return $this
     */
    protected function replaceClassName(&$stub)
    {
        $className = ucwords(Str::camel($this->argument('name')));

        $stub = str_replace('{{class}}', $className, $stub);

        return $this;
    }

    /**
     * Replace the table name in the stub.
     *
     * @param string $stub
     *
     * @return $this
     */
    protected function replaceTableName(&$stub)
    {
        $table = $this->meta['table'];

        $stub = str_replace('{{table}}', $table, $stub);

        return $this;
    }

    /**
     * Replace the schema for the stub.
     *
     * @param string $stub
     *
     * @return $this
     */
    protected function replaceSchema(&$stub)
    {
        if ($schema = $this->option('schema')) {
            $schema = $this->schemaParse($schema);
        }

        $schema = $this->syntaxBuilderCreate($schema, $this->meta);

        $stub = str_replace(['{{schema_up}}', '{{schema_down}}'], $schema, $stub);

        return $this;
    }

    /**
     * Get the class name for the Eloquent model generator.
     *
     * @return string
     */
    protected function getModelName()
    {
        return ucwords(Str::singular(Str::camel($this->meta['table'])));
    }

    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getArguments()
    {
        return [
            ['name', InputArgument::REQUIRED, 'The name of the migration'],
        ];
    }

    /**
     * Get the console command options.
     *
     * @return array
     */
    protected function getOptions()
    {
        return [
            ['schema', 's', InputOption::VALUE_OPTIONAL, 'Optional schema to be attached to the migration', null],
            ['model', null, InputOption::VALUE_OPTIONAL, 'Want a model for this table?', true],
        ];
    }

    /**
     * Parse the migration name into something we can use.
     *
     * @param string $name
     *
     * @return array
     */
    public function nameParse($name)
    {
        $segments = array_reverse(explode('_', $name));

        if ('table' == $segments[0]) {
            array_shift($segments);
        }

        return [
            'action' => $this->getAction($segments),
            'table' => $this->getTableName($segments),
        ];
    }

    /**
     * Calculate the table name.
     *
     * @param array $segments
     *
     * @return array
     */
    private function getTableName($segments)
    {
        $tableName = [];

        foreach ($segments as $segment) {
            if ($this->isConnectingWord($segment)) {
                break;
            }

            $tableName[] = $segment;
        }

        return implode('_', array_reverse($tableName));
    }

    /**
     * Determine the user's desired action for the migration.
     *
     * @param array $segments
     *
     * @return mixed
     */
    private function getAction(&$segments)
    {
        return $this->normalizeActionName(array_pop($segments));
    }

    /**
     * Normalize the user's chosen action to name to
     * something that we recognize.
     *
     * @param string $action
     *
     * @return string
     */
    private function normalizeActionName($action)
    {
        switch ($action) {
            case 'create':
            case 'make':
                return 'create';
            case 'delete':
            case 'destroy':
            case 'drop':
                return 'remove';
            case 'add':
            case 'append':
            case 'update':
            case 'insert':
                return 'add';
            default:
                return $action;
        }
    }

    /**
     * Determine if the current segment is a connecting word.
     *
     * @param string $segment
     *
     * @return bool
     */
    private function isConnectingWord($segment)
    {
        $connectors = ['to', 'from', 'and', 'with', 'for', 'in', 'of', 'on'];

        return in_array($segment, $connectors);
    }

    /**
     * The parsed schema.
     *
     * @var array
     */
    private $schema = [];

    /**
     * Parse the command line migration schema.
     * Ex: name:string, age:integer:nullable.
     *
     * @param string $schema
     *
     * @return array
     */
    public function schemaParse($schema)
    {
        $fields = $this->splitIntoFields($schema);

        foreach ($fields as $field) {
            $segments = $this->parseSegments($field);

            if ($this->fieldNeedsForeignConstraint($segments)) {
                unset($segments['options']['foreign']);

                // If the user wants a foreign constraint, then
                // we'll first add the regular field.
                $this->addField($segments);

                // And then add another field for the constraint.
                $this->addForeignConstraint($segments);

                continue;
            }

            $this->addField($segments);
        }

        return $this->schema;
    }

    /**
     * Add a field to the schema array.
     *
     * @param array $field
     *
     * @return $this
     */
    private function addField($field)
    {
        $this->schema[] = $field;

        return $this;
    }

    /**
     * Get an array of fields from the given schema.
     *
     * @param string $schema
     *
     * @return array
     */
    private function splitIntoFields($schema)
    {
        return preg_split('/,\s?(?![^()]*\))/', $schema);
    }

    /**
     * Get the segments of the schema field.
     *
     * @param string $field
     *
     * @return array
     */
    private function parseSegments($field)
    {
        $segments = explode(':', $field);

        $name = array_shift($segments);
        $type = array_shift($segments);
        $arguments = [];
        $options = $this->parseOptions($segments);

        // Do we have arguments being used here?
        // Like: string(100)
        if (preg_match('/(.+?)\(([^)]+)\)/', $type, $matches)) {
            $type = $matches[1];
            $arguments = explode(',', $matches[2]);
        }

        return compact('name', 'type', 'arguments', 'options');
    }

    /**
     * Parse any given options into something usable.
     *
     * @param array $options
     *
     * @return array
     */
    private function parseOptions($options)
    {
        if (empty($options)) {
            return [];
        }

        foreach ($options as $option) {
            if (Str::contains($option, '(')) {
                preg_match('/([a-z]+)\(([^\)]+)\)/i', $option, $matches);

                $results[$matches[1]] = $matches[2];
            } else {
                $results[$option] = true;
            }
        }

        return $results;
    }

    /**
     * Add a foreign constraint field to the schema.
     *
     * @param array $segments
     */
    private function addForeignConstraint($segments)
    {
        $string = sprintf(
            "%s:foreign:references('id'):on('%s')",
            $segments['name'],
            $this->getTableNameFromForeignKey($segments['name'])
        );

        $this->addField($this->parseSegments($string));
    }

    /**
     * Try to figure out the name of a table from a foreign key.
     * Ex: user_id => users.
     *
     * @param string $key
     *
     * @return string
     */
    private function getTableNameFromForeignKey($key)
    {
        return Str::plural(str_replace('_id', '', $key));
    }

    /**
     * Determine if the user wants a foreign constraint for the field.
     *
     * @param array $segments
     *
     * @return bool
     */
    private function fieldNeedsForeignConstraint($segments)
    {
        return array_key_exists('foreign', $segments['options']);
    }

    /**
     * A template to be inserted.
     *
     * @var string
     */
    private $template;

    /**
     * Create the PHP syntax for the given schema.
     *
     * @param array $schema
     * @param array $meta
     *
     * @return string
     *
     * @throws Exception
     */
    public function syntaxBuilderCreate($schema, $meta)
    {
        $up = $this->createSchemaForUpMethod($schema, $meta);
        $down = $this->createSchemaForDownMethod($schema, $meta);

        return compact('up', 'down');
    }

    /**
     * Create the schema for the "up" method.
     *
     * @param string $schema
     * @param array  $meta
     *
     * @return string
     *
     * @throws Exception
     */
    private function createSchemaForUpMethod($schema, $meta)
    {
        $fields = $this->constructSchema($schema);

        if ('create' == $meta['action']) {
            return $this->insert($fields)->into($this->getCreateSchemaWrapper());
        }

        if ('add' == $meta['action']) {
            return $this->insert($fields)->into($this->getChangeSchemaWrapper());
        }

        if ('remove' == $meta['action']) {
            $fields = $this->constructSchema($schema, 'Drop');

            return $this->insert($fields)->into($this->getChangeSchemaWrapper());
        }

        // Otherwise, we have no idea how to proceed.
        throw new Exception('Could not determine what you are trying to do. Sorry! Check your migration name.');
    }

    /**
     * Construct the syntax for a down field.
     *
     * @param array $schema
     * @param array $meta
     *
     * @return string
     *
     * @throws Exception
     */
    private function createSchemaForDownMethod($schema, $meta)
    {
        // If the user created a table, then for the down
        // method, we should drop it.
        if ('create' == $meta['action']) {
            return sprintf("Schema::dropIfExists('%s');", $meta['table']);
        }

        // If the user added columns to a table, then for
        // the down method, we should remove them.
        if ('add' == $meta['action']) {
            $fields = $this->constructSchema($schema, 'Drop');

            return $this->insert($fields)->into($this->getChangeSchemaWrapper());
        }

        // If the user removed columns from a table, then for
        // the down method, we should add them back on.
        if ('remove' == $meta['action']) {
            $fields = $this->constructSchema($schema);

            return $this->insert($fields)->into($this->getChangeSchemaWrapper());
        }

        // Otherwise, we have no idea how to proceed.
        throw new Exception('Could not determine what you are trying to do. Sorry! Check your migration name.');
    }

    /**
     * Store the given template, to be inserted somewhere.
     *
     * @param string $template
     *
     * @return $this
     */
    private function insert($template)
    {
        $this->template = $template;

        return $this;
    }

    /**
     * Get the stored template, and insert into the given wrapper.
     *
     * @param string $wrapper
     * @param string $placeholder
     *
     * @return mixed
     */
    private function into($wrapper, $placeholder = 'schema_up')
    {
        return str_replace('{{'.$placeholder.'}}', $this->template, $wrapper);
    }

    /**
     * Get the wrapper template for a "create" action.
     *
     * @return string
     */
    private function getCreateSchemaWrapper()
    {
        return file_get_contents(resource_path('stubs/schema-create.stub'));
    }

    /**
     * Get the wrapper template for an "add" action.
     *
     * @return string
     */
    private function getChangeSchemaWrapper()
    {
        return file_get_contents(resource_path('stubs/schema-change.stub'));
    }

    /**
     * Construct the schema fields.
     *
     * @param array  $schema
     * @param string $direction
     *
     * @return array
     */
    private function constructSchema($schema, $direction = 'Add')
    {
        if (!$schema) {
            return '';
        }

        $fields = array_map(function ($field) use ($direction) {
            $method = "{$direction}Column";

            return $this->$method($field);
        }, $schema);

        return implode("\n".str_repeat(' ', 12), $fields);
    }

    /**
     * Construct the syntax to add a column.
     *
     * @param string $field
     *
     * @return string
     */
    private function addColumn($field)
    {
        $syntax = sprintf("\$table->%s('%s')", $field['type'], $field['name']);

        // If there are arguments for the schema type, like decimal('amount', 5, 2)
        // then we have to remember to work those in.
        if ($field['arguments']) {
            $syntax = substr($syntax, 0, -1).', ';

            $syntax .= implode(', ', $field['arguments']).')';
        }

        foreach ($field['options'] as $method => $value) {
            $syntax .= sprintf('->%s(%s)', $method, true === $value ? '' : $value);
        }

        return $syntax .= ';';
    }

    /**
     * Construct the syntax to drop a column.
     *
     * @param string $field
     *
     * @return string
     */
    private function dropColumn($field)
    {
        return sprintf("\$table->dropColumn('%s');", $field['name']);
    }
}
