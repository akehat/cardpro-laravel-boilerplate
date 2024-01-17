<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class finix_payments extends Model
{
    use HasFactory;
    protected $table="finix_payments";
    protected $guarded=['id'];
    public static function fromArray($array){
        foreach ($array as $value) {
            $value=(object)$value;
            $found=finix_payments::where('finix_id',$value->id)->first();
            if($found==null){
               $found=finix_payments::create([
                    'finix_id'=>$value->id??null,
                    'created_at_finix'=>$value->created_at??null,
                    'updated_at_finix'=>$value->updated_at??null,
                    'additional_buyer_charges'=>$value->additional_buyer_charges??null,
                    'additional_healthcare_data'=>$value->additional_healthcare_data??null,
                    'additional_purchase_data'=>$value->additional_purchase_data??null,
                    'address_verification'=>$value->address_verification??null,
                    'amount'=>$value->amount??null,
                    'amount_requested'=>$value->amount_requested??null,
                    'application'=>$value->application??null,
                    'currency'=>$value->currency??null,
                    'destination'=>$value->destination??null,
                    'externally_funded'=>$value->externally_funded??null,
                    'failure_code'=>$value->failure_code??null,
                    'failure_message'=>$value->failure_message??null,
                    'fee'=>$value->fee??null,
                    'idempotency_id'=>$value->idempotency_id??null,
                    'merchant'=>$value->merchant??null,
                    'merchant_identity'=>$value->merchant_identity??null,
                    'messages'=>$value->messages??null,
                    'parent_transfer'=>$value->parent_transfer??null,
                    'parent_transfer_trace_id'=>$value->parent_transfer_trace_id??null,
                    'raw'=>$value->raw??null,
                    'ready_to_settle_at'=>$value->ready_to_settle_at??null,
                    'receipt_last_printed_at'=>$value->receipt_last_printed_at??null,
                    'security_code_verification'=>$value->security_code_verification??null,
                    'source'=>$value->source??null,
                    'split_transfers'=>$value->split_transfers??null,
                    'state'=>$value->state??null,
                    'statement_descriptor'=>$value->statement_descriptor??null,
                    'subtype'=>$value->subtype??null,
                    'tags'=>json_encode($value->tags)??null,
                    'trace_id'=>$value->trace_id??null,
                    'type'=>$value->type??null,
                    'fee_type'=>$value->fee_type??null
                ]);
            }else{
                $found::update([
                    'finix_id'=>$value->id??null,
                    'created_at_finix'=>$value->created_at??null,
                    'updated_at_finix'=>$value->updated_at??null,
                    'additional_buyer_charges'=>$value->additional_buyer_charges??null,
                    'additional_healthcare_data'=>$value->additional_healthcare_data??null,
                    'additional_purchase_data'=>$value->additional_purchase_data??null,
                    'address_verification'=>$value->address_verification??null,
                    'amount'=>$value->amount??null,
                    'amount_requested'=>$value->amount_requested??null,
                    'application'=>$value->application??null,
                    'currency'=>$value->currency??null,
                    'destination'=>$value->destination??null,
                    'externally_funded'=>$value->externally_funded??null,
                    'failure_code'=>$value->failure_code??null,
                    'failure_message'=>$value->failure_message??null,
                    'fee'=>$value->fee??null,
                    'idempotency_id'=>$value->idempotency_id??null,
                    'merchant'=>$value->merchant??null,
                    'merchant_identity'=>$value->merchant_identity??null,
                    'messages'=>$value->messages??null,
                    'parent_transfer'=>$value->parent_transfer??null,
                    'parent_transfer_trace_id'=>$value->parent_transfer_trace_id??null,
                    'raw'=>$value->raw??null,
                    'ready_to_settle_at'=>$value->ready_to_settle_at??null,
                    'receipt_last_printed_at'=>$value->receipt_last_printed_at??null,
                    'security_code_verification'=>$value->security_code_verification??null,
                    'source'=>$value->source??null,
                    'split_transfers'=>$value->split_transfers??null,
                    'state'=>$value->state??null,
                    'statement_descriptor'=>$value->statement_descriptor??null,
                    'subtype'=>$value->subtype??null,
                    'tags'=>json_encode($value->tags)??null,
                    'trace_id'=>$value->trace_id??null,
                    'type'=>$value->type??null,
                    'fee_type'=>$value->fee_type??null
                ]);
            }
            $found->save();
            $found->refresh();
        }
    }
}
