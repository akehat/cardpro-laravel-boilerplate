<?php

namespace App\Models;

use App\Http\Controllers\API\formController;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class pci_forms extends Model
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
    use HasFactory;
    protected $table="pci_forms";
    protected $guarded=['id'];
    public static $name='compliance_forms';
    public static function updateFromId($id){
        self::fromArray([json_decode(formController::fetchPCIForm(config("app.api_username"),config("app.api_password"),$id)[0])]);
     }
    public static function runUpdate(){
        $result= formController::listPCIforms(config("app.api_username"),config("app.api_password"));
        $object=json_decode($result[0]);
        while(isset($object->_embedded)&&isset($object->_embedded->compliance_forms)&&isset($object->page)&&isset($object->page->next_cursor)&&count($object->_embedded->compliance_forms)>0){
            self::fromArray($object->_embedded->compliance_forms);
         $nextArray=['after_cursor'=>$object->page->next_cursor];
         $result= formController::listPCIforms(config("app.api_username"),config("app.api_password"),'https://finix.sandbox-payments-api.com',$nextArray);
         $object=json_decode($result[0]);
        }
     }
    public static function fromArray(array $array)
    {
        foreach ($array as $data) {
            $data = (object)$data;

            $found = self::where('finix_id', $data->id)->first();

            if ($found == null) {
                $found = self::create([
                    'finix_id' => $data->id ?? null,
                    'finix_created_at' => $data->created_at ?? null,
                    'finix_updated_at' => $data->updated_at ?? null,
                    'linked_to' => $data->linked_to ?? null,
                    'linked_type' => $data->linked_type ?? null,
                    'application' => $data->application ?? null,
                    'type' => $data->type ?? null,
                    'version' => $data->version ?? null,
                    'valid_from' => $data->valid_from ?? null,
                    'valid_until' => $data->valid_until ?? null,
                    'tags' => json_encode($data->tags) ?? null,
                    'pci_saq_a' => json_encode($data->pci_saq_a) ?? null,
                    'due_at' => $data->due_at ?? null,
                    'compliance_form_template' => $data->compliance_form_template ?? null,
                    'files' => json_encode($data->files) ?? null,
                    'state' => $data->state ?? null,
                ]);
            } else {
                $found->update([
                    'finix_id' => $data->id ?? null,
                    'finix_created_at' => $data->created_at ?? null,
                    'finix_updated_at' => $data->updated_at ?? null,
                    'linked_to' => $data->linked_to ?? null,
                    'linked_type' => $data->linked_type ?? null,
                    'application' => $data->application ?? null,
                    'type' => $data->type ?? null,
                    'version' => $data->version ?? null,
                    'valid_from' => $data->valid_from ?? null,
                    'valid_until' => $data->valid_until ?? null,
                    'tags' => json_encode($data->tags) ?? null,
                    'pci_saq_a' => json_encode($data->pci_saq_a) ?? null,
                    'due_at' => $data->due_at ?? null,
                    'compliance_form_template' => $data->compliance_form_template ?? null,
                    'files' => json_encode($data->files) ?? null,
                    'state' => $data->state ?? null,
                ]);
            }

            // Save and refresh the model
            $found->save();
            $found->refresh();
        }
    }
}
