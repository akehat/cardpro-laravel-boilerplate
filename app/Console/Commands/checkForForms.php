<?php

namespace App\Console\Commands;

use App\Models\awaiting_PCI;
use App\Models\awaiting_PCI_live;
use App\Models\awaiting_users;
use App\Models\awaiting_users_live;
use Error;
use Exception;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class checkForForms extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'check:awaiting';

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
        $pcis=awaiting_PCI::get();
        foreach($pcis as $pci){
            try{
                if($pci->fillOutForm()===true){
                    awaiting_users::where('id',$pci->id)->delete();
                }
            }catch(Exception | Error $e){
                Log::info($e->getMessage());
            }
        }
        $pcis=awaiting_PCI_live::get();
        foreach($pcis as $pci){
            try{
                if($pci->checkReady()){
                    if($pci->fillOutForm()===true){
                        awaiting_users::where('id',$pci->id)->delete();
                    }
                }
            }catch(Exception | Error $e){
                Log::info($e->getMessage());
            }
        }
        $awaitingUsers=awaiting_users::get();
        foreach($awaitingUsers as $awaitingUser){
            try{
                if($awaitingUser->checkReady()){
                    if($awaitingUser->completeSignup()===true){
                        awaiting_users::where('id',$awaitingUser->id)->delete();
                    }
                }
            }catch(Exception | Error $e){
                Log::info($e->getMessage());
            }
        }
        $awaitingUsers=awaiting_users_live::get();
        foreach($awaitingUsers as $awaitingUser){
            try{
                if($awaitingUser->checkReady()){
                    if($awaitingUser->completeSignup()===true){
                        awaiting_users_live::where('id',$awaitingUser->id)->delete();
                    }
                }
            }catch(Exception | Error $e){
                Log::info($e->getMessage());
            }
        }
        return 0;
    }
}
