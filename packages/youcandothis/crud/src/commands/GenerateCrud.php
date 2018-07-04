<?php

namespace Youcandothis\Crud\Src\Commands;
use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class GenerateCrud extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $name = 'generate:crud';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate crud just by add your entity name.';

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
    public function fire()
    {
        $option = $this->option('example');
        print('hiiiiiiiiiiiiii');

        $this->info('This a command test:'.$option);

    }
    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getArguments()
    {
        return [
            ['model_name', InputArgument::OPTIONAL, 'An example argument.'],
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
            ['fields', null, InputOption::VALUE_OPTIONAL, 'An example option.', null],
        ];


    }

    public function handle()
    {
        print($this->argument('model_name'));
        print($this->option('fields'));
        $modelName = $this->argument('model_name');
        if ($modelName === '' || is_null($modelName) || empty($modelName)) {
             $this->error('Model Name Invalid..!');
         }


             $modelFileName = 'app/' . $modelName . '.php';

             if(! file_exists($modelFileName)) {
                 $modelFileContent = "<?php\n\nnamespace App;\n\nuse Illuminate\Database\Eloquent\Model;\n\nclass " . $modelName . " extends Model\n{\n\n}";

                 file_put_contents($modelFileName, $modelFileContent);
                 $this->info('Model ' . $modelName . ' Created Successfully.');

             } else {
                 $this->error('Model ' . $modelName . ' Already Exists.');
             }
    }
}
