<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class DbUser extends Command
{
    protected $signature = 'db:user';
    protected $description = 'Create a database user with necessary permissions';

    public function handle()
    {
        $database = config('database.connections.mysql.database');
        $username = config('database.connections.mysql.username');
        $password = config('database.connections.mysql.password');
        $host = config('database.connections.mysql.host', '127.0.0.1');

        $query = "CREATE USER IF NOT EXISTS '$username'@'$host' IDENTIFIED BY '$password';";
        DB::statement($query);

        $query = "GRANT ALL PRIVILEGES ON $database.* TO '$username'@'$host';";
        DB::statement($query);

        $query = 'FLUSH PRIVILEGES;';
        DB::statement($query);

        $this->info("User '$username' created with necessary permissions.");
    }
}
