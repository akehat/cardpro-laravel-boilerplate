<?php

namespace App\Console\Commands;

use Cache;
use Error;
use Exception;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Log;

class reset_column_cache extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'remove:columncache';

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
     * @return int
     */
    public function handle()
    {
        $modelsPath = app_path('Models');

        if (File::isDirectory($modelsPath)) {
            $files = File::allFiles($modelsPath);

            foreach ($files as $file) {
                $modelClass = $this->getModelNamespace($file);

                if (class_exists($modelClass) && method_exists($modelClass, 'forgetColumnNames')) {
                    Log::info("Executing reset on $modelClass");
                    try{
                    $modelClass::forgetColumnNames();
                    }catch(Exception | Error $e){
                        Log::info($e->getMessage());
                        // Log::info($e->getTrace());
                    }
                }
            }
        } else {
            Log::error("Models directory not found.");
        }
    }

    protected function getModelNamespace($file)
    {
        $namespace = 'App\\Models';

        $class = pathinfo($file->getFilename(), PATHINFO_FILENAME);

        return $namespace . '\\' . $class;
    }
}
