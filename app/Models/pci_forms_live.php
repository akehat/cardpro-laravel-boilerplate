<?php

namespace App\Models;

use App\Http\Controllers\API\formController;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class pci_forms_live extends Model
{
    use HasFactory;
    protected $table="pci_forms_live";
    protected $guarded=['id'];
    public static $name='compliance_forms';
    public static function updateFromId_live($id){
        self::fromArray([json_decode(formController::fetchPCIForm(config("app.api_username"),config("app.api_password"),$id,'https://finix.live-payments-api.com')[0])]);
     }
    public static function runUpdate(){
        $result= formController::listPCIforms(config("app.api_username"),config("app.api_password"));
        $object=json_decode($result[0]);
        while(isset($object->_embedded)&&isset($object->_embedded->compliance_forms)&&isset($object->page)&&isset($object->page->next_cursor)&&count($object->_embedded->compliance_forms)>0){
            self::fromArray($object->_embedded->compliance_forms);
         $nextArray=['after_cursor'=>$object->page->next_cursor];
         $result= formController::listPCIforms(config("app.api_username"),config("app.api_password"),'https://finix.live-payments-api.com',$nextArray);
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
