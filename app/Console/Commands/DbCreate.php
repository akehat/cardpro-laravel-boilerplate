<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class DbCreate extends Command
{
    protected $signature = 'db:create';
    protected $description = 'Create the database';

    public function handle()
    {
        $database = config('database.connections.mysql.database');
        $charset = config('database.connections.mysql.charset', 'utf8mb4');
        $collation = config('database.connections.mysql.collation', 'utf8mb4_unicode_ci');

        config(['database.connections.mysql.database' => null]);

        $query = "CREATE DATABASE IF NOT EXISTS $database CHARACTER SET $charset COLLATE $collation;";
        DB::statement($query);

        $this->info("Database '$database' created successfully.");
    }
}
