<?php

namespace App\Jobs;

use Error;
use Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;

class UpdateJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $modelsPath = app_path('Models');

        if (File::isDirectory($modelsPath)) {
            $files = File::allFiles($modelsPath);

            foreach ($files as $file) {
                $modelClass = $this->getModelNamespace($file);

                if (class_exists($modelClass) && method_exists($modelClass, 'runUpdate')) {
                    Log::info("Executing runUpdate on $modelClass");
                    try{
                    $modelClass::runUpdate();
                    }catch(Exception | Error $e){
                        Log::info($e->getMessage());
                        Log::info($e->getTrace());
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
