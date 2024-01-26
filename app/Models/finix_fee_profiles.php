<?php

namespace App\Models;

use App\Http\Controllers\API\merchantsController;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class finix_fee_profiles extends Model
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
    protected $table="finix_fee_profiles";
    protected $guarded=['id'];
    public static $name='fee_profiles';
    public static function updateFromId($id){
       self::fromArray([json_decode(merchantsController::fetchFeeProfile(config("app.api_username"),config("app.api_password"),$id)[0])]);
    }
    public static function runUpdate(){
        $result= merchantsController::listFeeProfile(config("app.api_username"),config("app.api_password"));
        $object=json_decode($result[0]);
        while(isset($object->_embedded)&&isset($object->_embedded->fee_profiles)&&isset($object->page)&&isset($object->page->next_cursor)&&count($object->_embedded->fee_profiles)>0){
            self::fromArray($object->_embedded->fee_profiles);
         $nextArray=['after_cursor'=>$object->page->next_cursor];
         $result= merchantsController::listFeeProfile(config("app.api_username"),config("app.api_password"),'https://finix.sandbox-payments-api.com',$nextArray);
         $object=json_decode($result[0]);
        }
     }
    public static function fromArray($array){
        foreach ($array as $value) {
            $value=(object)$value;
            $found=finix_fee_profiles::where('finix_id',$value->id)->first();
            if($found==null){
               $found=finix_fee_profiles::create( [
                'finix_id' => $value->id ?? null,
                'ach_basis_points' => $value->ach_basis_points ?? null,
                'ach_credit_return_fixed_fee' => $value->ach_credit_return_fixed_fee ?? null,
                'ach_debit_return_fixed_fee' => $value->ach_debit_return_fixed_fee ?? null,
                'ach_fixed_fee' => $value->ach_fixed_fee ?? null,
                'american_express_assessment_basis_points' => $value->american_express_assessment_basis_points ?? null,
                'american_express_basis_points' => $value->american_express_basis_points ?? null,
                'american_express_charge_interchange' => $value->american_express_charge_interchange ?? null,
                'american_express_externally_funded_basis_points' => $value->american_express_externally_funded_basis_points ?? null,
                'american_express_externally_funded_fixed_fee' => $value->american_express_externally_funded_fixed_fee ?? null,
                'american_express_fixed_fee' => $value->american_express_fixed_fee ?? null,
                'ancillary_fixed_fee_primary' => $value->ancillary_fixed_fee_primary ?? null,
                'ancillary_fixed_fee_secondary' => $value->ancillary_fixed_fee_secondary ?? null,
                'application' => $value->application ?? null,
                'basis_points' => $value->basis_points ?? null,
                'charge_interchange' => $value->charge_interchange ?? null,
                'diners_club_basis_points' => $value->diners_club_basis_points ?? null,
                'diners_club_charge_interchange' => $value->diners_club_charge_interchange ?? null,
                'diners_club_fixed_fee' => $value->diners_club_fixed_fee ?? null,
                'discover_assessments_basis_points' => $value->discover_assessments_basis_points ?? null,
                'discover_basis_points' => $value->discover_basis_points ?? null,
                'discover_charge_interchange' => $value->discover_charge_interchange ?? null,
                'discover_value_usage_fixed_fee' => $value->discover_value_usage_fixed_fee ?? null,
                'discover_externally_funded_basis_points' => $value->discover_externally_funded_basis_points ?? null,
                'discover_externally_funded_fixed_fee' => $value->discover_externally_funded_fixed_fee ?? null,
                'discover_fixed_fee' => $value->discover_fixed_fee ?? null,
                'discover_network_authorization_fixed_fee' => $value->discover_network_authorization_fixed_fee ?? null,
                'dispute_fixed_fee' => $value->dispute_fixed_fee ?? null,
                'dispute_inquiry_fixed_fee' => $value->dispute_inquiry_fixed_fee ?? null,
                'externally_funded_basis_points' => $value->externally_funded_basis_points ?? null,
                'externally_funded_fixed_fee' => $value->externally_funded_fixed_fee ?? null,
                'fixed_fee' => $value->fixed_fee ?? null,
                'jcb_basis_points' => $value->jcb_basis_points ?? null,
                'jcb_charge_interchange' => $value->jcb_charge_interchange ?? null,
                'jcb_fixed_fee' => $value->jcb_fixed_fee ?? null,
                'mastercard_acquirer_fees_basis_points' => $value->mastercard_acquirer_fees_basis_points ?? null,
                'mastercard_assessments_over1k_basis_points' => $value->mastercard_assessments_over1k_basis_points ?? null,
                'mastercard_assessments_under1k_basis_points' => $value->mastercard_assessments_under1k_basis_points ?? null,
                'mastercard_basis_points' => $value->mastercard_basis_points ?? null,
                'mastercard_charge_interchange' => $value->mastercard_charge_interchange ?? null,
                'mastercard_fixed_fee' => $value->mastercard_fixed_fee ?? null,
                'qualified_tiers' => $value->qualified_tiers ?? null,
                'rounding_mode' => $value->rounding_mode ?? null,
                'tags' => $value->tags ?? null,
                'visa_acquirer_processing_fixed_fee' => $value->visa_acquirer_processing_fixed_fee ?? null,
                'visa_assessments_basis_points' => $value->visa_assessments_basis_points ?? null,
                'visa_base_II_credit_voucher_fixed_fee' => $value->visa_base_II_credit_voucher_fixed_fee ?? null,
                'visa_base_II_system_file_transmission_fixed_fee' => $value->visa_base_II_system_file_transmission_fixed_fee ?? null,
                'visa_basis_points' => $value->visa_basis_points ?? null,
                'visa_charge_interchange' => $value->visa_charge_interchange ?? null,
                'visa_credit_voucher_fixed_fee' => $value->visa_credit_voucher_fixed_fee ?? null,
                'visa_fixed_fee' => $value->visa_fixed_fee ?? null,
                'visa_kilobyte_access_fixed_fee' => $value->visa_kilobyte_access_fixed_fee ?? null,
            ]);
            }else{
                $found->update([
                    'finix_id' => $value->id ?? null,
                    'ach_basis_points' => $value->ach_basis_points ?? null,
                    'ach_credit_return_fixed_fee' => $value->ach_credit_return_fixed_fee ?? null,
                    'ach_debit_return_fixed_fee' => $value->ach_debit_return_fixed_fee ?? null,
                    'ach_fixed_fee' => $value->ach_fixed_fee ?? null,
                    'american_express_assessment_basis_points' => $value->american_express_assessment_basis_points ?? null,
                    'american_express_basis_points' => $value->american_express_basis_points ?? null,
                    'american_express_charge_interchange' => $value->american_express_charge_interchange ?? null,
                    'american_express_externally_funded_basis_points' => $value->american_express_externally_funded_basis_points ?? null,
                    'american_express_externally_funded_fixed_fee' => $value->american_express_externally_funded_fixed_fee ?? null,
                    'american_express_fixed_fee' => $value->american_express_fixed_fee ?? null,
                    'ancillary_fixed_fee_primary' => $value->ancillary_fixed_fee_primary ?? null,
                    'ancillary_fixed_fee_secondary' => $value->ancillary_fixed_fee_secondary ?? null,
                    'application' => $value->application ?? null,
                    'basis_points' => $value->basis_points ?? null,
                    'charge_interchange' => $value->charge_interchange ?? null,
                    'diners_club_basis_points' => $value->diners_club_basis_points ?? null,
                    'diners_club_charge_interchange' => $value->diners_club_charge_interchange ?? null,
                    'diners_club_fixed_fee' => $value->diners_club_fixed_fee ?? null,
                    'discover_assessments_basis_points' => $value->discover_assessments_basis_points ?? null,
                    'discover_basis_points' => $value->discover_basis_points ?? null,
                    'discover_charge_interchange' => $value->discover_charge_interchange ?? null,
                    'discover_value_usage_fixed_fee' => $value->discover_value_usage_fixed_fee ?? null,
                    'discover_externally_funded_basis_points' => $value->discover_externally_funded_basis_points ?? null,
                    'discover_externally_funded_fixed_fee' => $value->discover_externally_funded_fixed_fee ?? null,
                    'discover_fixed_fee' => $value->discover_fixed_fee ?? null,
                    'discover_network_authorization_fixed_fee' => $value->discover_network_authorization_fixed_fee ?? null,
                    'dispute_fixed_fee' => $value->dispute_fixed_fee ?? null,
                    'dispute_inquiry_fixed_fee' => $value->dispute_inquiry_fixed_fee ?? null,
                    'externally_funded_basis_points' => $value->externally_funded_basis_points ?? null,
                    'externally_funded_fixed_fee' => $value->externally_funded_fixed_fee ?? null,
                    'fixed_fee' => $value->fixed_fee ?? null,
                    'jcb_basis_points' => $value->jcb_basis_points ?? null,
                    'jcb_charge_interchange' => $value->jcb_charge_interchange ?? null,
                    'jcb_fixed_fee' => $value->jcb_fixed_fee ?? null,
                    'mastercard_acquirer_fees_basis_points' => $value->mastercard_acquirer_fees_basis_points ?? null,
                    'mastercard_assessments_over1k_basis_points' => $value->mastercard_assessments_over1k_basis_points ?? null,
                    'mastercard_assessments_under1k_basis_points' => $value->mastercard_assessments_under1k_basis_points ?? null,
                    'mastercard_basis_points' => $value->mastercard_basis_points ?? null,
                    'mastercard_charge_interchange' => $value->mastercard_charge_interchange ?? null,
                    'mastercard_fixed_fee' => $value->mastercard_fixed_fee ?? null,
                    'qualified_tiers' => $value->qualified_tiers ?? null,
                    'rounding_mode' => $value->rounding_mode ?? null,
                    'tags' => $value->tags ?? null,
                    'visa_acquirer_processing_fixed_fee' => $value->visa_acquirer_processing_fixed_fee ?? null,
                    'visa_assessments_basis_points' => $value->visa_assessments_basis_points ?? null,
                    'visa_base_II_credit_voucher_fixed_fee' => $value->visa_base_II_credit_voucher_fixed_fee ?? null,
                    'visa_base_II_system_file_transmission_fixed_fee' => $value->visa_base_II_system_file_transmission_fixed_fee ?? null,
                    'visa_basis_points' => $value->visa_basis_points ?? null,
                    'visa_charge_interchange' => $value->visa_charge_interchange ?? null,
                    'visa_credit_voucher_fixed_fee' => $value->visa_credit_voucher_fixed_fee ?? null,
                    'visa_fixed_fee' => $value->visa_fixed_fee ?? null,
                    'visa_kilobyte_access_fixed_fee' => $value->visa_kilobyte_access_fixed_fee ?? null,
                ]);
            }
            $found->save();
            $found->refresh();
        }
    }
}
