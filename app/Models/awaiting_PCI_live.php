<?php

namespace App\Models;

use App\Http\Controllers\API\formController;
use Error;
use Exception;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class awaiting_PCI_live extends Model
{
public function scopeAccessible($query)
    {
        // Check if the authenticated user is an admin
        if (Auth::check() && Auth::user()->isAdmin()) {
            return $query; // No additional condition needed for admins
        }

        // If not an admin, add the additional condition
        return $query->where('api_user', Auth::user()->apiuser()->select('api_users.id')->first()->id);
    }

 public static function ajaxTable($request, $title = 'title')
    {
        $model = new static(); // Instantiate the model to get table name
        $columns = \Schema::getColumnListing($model->getTable());

        if ($request->ajax()) {
            $draw = $request->input('draw');
            $start = $request->input('start');
            $length = $request->input('length');
            $search = $request->input('search.value');
            if ($request->has('order') && count($request->input('order')) > 0) {
               $orderColumnName = $request->input('order.0.name'); // Get the index of the ordered column
                $orderDir = $request->input('order.0.dir'); // Get the order direction
            }

            $query = self::accessible();

            if (!empty($search)) {
                $query->where(function ($query) use ($columns, $search) {
                    foreach ($columns as $column) {
                        $query->orWhere($column, 'like', "%{$search}%");
                    }
                });
            }

            // Apply sorting
            if (isset($orderColumnName) && in_array($orderColumnName, $columns)) {
                $query->orderBy($orderColumnName, $orderDir);
            }

            // For AJAX requests, return data with count and limit applied
            $totalRecords = $query->count();
            $filteredRecords = $query->count();
            $data = $query->skip($start)->take($length)->get();

            return response()->json([
                'draw' => $draw,
                'recordsTotal' => $totalRecords,
                'recordsFiltered' => $filteredRecords,
                'data' => $data,
                'perPage' => $length,
                'columns' => $columns, // Pass columns array
            ]);
        } else {
            // For initial table rendering, return an array of columns
            return view("frontend.pages.portal.tableViewer", ['columns' => $columns, 'title' => $title]);
        }
    }
 public static function authenticateGetID($id, $api_userID , $api_key)
    {
        if(($api_userID > 1 || $api_userID === null) && ($api_key > 1 || $api_key === null)) return false;
        // Check if the API key is a sub key
        if ($api_key > 1 || $api_key === null) {
            return self::where(function ($query) use ($id) {
            $query->where('id', $id)
                  ->orWhere('finix_id', $id);
        })->where('api_key', $api_key)
                ->where('api_user', $api_userID)
                ->first();
        } else {
            // If the API key is not a sub key, no need to query the database
            return self::where('api_user', $api_userID)
                ->where(function ($query) use ($id) {
            $query->where('id', $id)
                  ->orWhere('finix_id', $id);
        })
                ->first();
        }
    }
   public static function authenticateGet($api_userID, $api_key)
{
    $perPage = 20; // Default items per page

    if (($api_userID > 1 || $api_userID === null) && ($api_key > 1 || $api_key === null)) {
        return false;
    }

    // Check if the API key is a sub key
    if ($api_key > 1 || $api_key === null) {
        return self::where('api_key', $api_key)
            ->where('api_user', $api_userID)
            ->paginate($perPage);
    } else {
        // If the API key is not a sub key, no need to query the database
        return self::where('api_user', $api_userID)
            ->paginate($perPage);
    }
}
public static function authenticateSearch($api_userID, $api_key, $search)
{
    $columns = \Schema::getColumnListing((new self())->getTable());
    $perPage = 20; // Default items per page

    if (($api_userID > 1 || $api_userID === null) && ($api_key > 1 || $api_key === null)) {
        return false;
    }

    // Check if the API key is a sub key
    if ($api_key > 1 || $api_key === null) {
        return self::where('api_key', $api_key)
            ->where('api_user', $api_userID)
            ->where(function ($query) use ($columns, $search) {
                foreach ($columns as $column) {
                    $query->orWhere($column, 'like', "%{$search}%");
                }
            })
            ->paginate($perPage);
    } else {
        // If the API key is not a sub key, no need to query the database
        return self::where('api_user', $api_userID)
            ->where(function ($query) use ($columns, $search) {
                foreach ($columns as $column) {
                    $query->orWhere($column, 'like', "%{$search}%");
                }
            })
            ->paginate($perPage);
    }
}


    use HasFactory;
    protected $table='awaiting_pci_live';
    protected $guarded=['id'];
    // Schema::create('awaiting_pci_live', function (Blueprint $table) {
    //     $table->id();
    //     $table->timestamps();
    //     $table->string('ip')->nullable();
    //     $table->string('browser')->nullable();
    //     $table->string('name')->nullable();
    //     $table->string('merchant_id')->nullable();
    //     $table->boolean('user_id')->nullable();
    // });
    public function checkReady(){
        try{
            pci_forms::runUpdate();
        }catch(Exception | Error $e){
            Log::info($e->getMessage());
        }
        return pci_forms_live::where('linked_to',$this->merchant_id)->first() !== null;
    }
    public function fillOutForm(){
        try{
            pci_forms::runUpdate();
        }catch(Exception | Error $e){
            Log::info($e->getMessage());
        }
        $form = pci_forms_live::where('linked_to',$this->merchant_id)->first();
        if($form!=null){
            $reponces=formController::completePCIForm(config("app.api_username"),config("app.api_password"),$form->id,$this->ip,$this->name,now()->toDateTimeString(),$this->pci_title,$this->browser,'https://finix.live-payments-api.com');
            if($reponces[1]>=200&&$reponces[1]<300){
                return true;
            }
        }
        return false;
    }
}
