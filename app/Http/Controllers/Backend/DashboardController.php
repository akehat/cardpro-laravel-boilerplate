<?php

namespace App\Http\Controllers\Backend;

use Error;
use Exception;
use File;
use Log;
use Request;

/**
 * Class DashboardController.
 */
class DashboardController
{
    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        return view('backend.dashboard');
    }
    public function tableController()
{
    $modelsPath = app_path('Models');
    $tables = [];

    if (File::isDirectory($modelsPath)) {
        $files = File::allFiles($modelsPath);

        foreach ($files as $file) {
            $modelClass = $this->getModelNamespace($file);

            if (class_exists($modelClass) && method_exists($modelClass, 'getColumnNames')) {
                try {
                    $model = new $modelClass(); // Instantiate the model to get table name
                    $columns = $modelClass::getColumnNames($model->getTable(), true);
                    $removed = $modelClass::getRemovedNames($model->getTable(),false);

                    $tables[$model->getTable()] = [$columns,$removed];
                } catch (Exception | Error $e) {
                    // dd($e);
                    Log::info($e->getMessage());
                    // Log::info($e->getTrace());
                }
            }
        }
    } else {
        Log::error("Models directory not found.");
    }
    return view('backend.tableController', compact('tables'));
}

    protected function getModelNamespace($file)
    {
        $namespace = 'App\\Models';

        $class = pathinfo($file->getFilename(), PATHINFO_FILENAME);

        return $namespace . '\\' . $class;
    }
    public function updateTables()
    {

        $request=request()->all();
        $modelsPath = app_path('Models');
        if (File::isDirectory($modelsPath)) {
            $files = File::allFiles($modelsPath);

            foreach ($files as $file) {
                $modelClass = $this->getModelNamespace($file);

                if (class_exists($modelClass) && method_exists($modelClass, 'setRemovedNames')) {
                    try {
                        $model = new $modelClass(); // Instantiate the model to get table name
                        $table=$model->getTable();
                        if (in_array($table,array_keys($request))){

                            $modelClass::setRemovedNames($table,$request[$table]);
                        }
                    } catch (Exception | Error $e) {
                        Log::info($e->getMessage());
                        // Log::info($e->getTrace());
                    }
                }
            }
        } else {
            Log::error("Models directory not found.");
        }

        return response()->json(["worked"=>"removed columns added"]);
    }

}
