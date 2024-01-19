<?php

namespace App\Console\Commands;

use App\Jobs\UpdateJob;
use Illuminate\Console\Command;

class updateDBFromFinix extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update:db';

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
        $updateJob = new UpdateJob();
        // Dispatch the job
        dispatch($updateJob);
        return 0;
    }
}
