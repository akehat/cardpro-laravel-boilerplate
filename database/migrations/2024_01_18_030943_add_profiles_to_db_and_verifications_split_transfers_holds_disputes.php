<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddProfilesToDbAndVerificationsSplitTransfersHoldsDisputes extends Migration
{
     /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('authorizations', function (Blueprint $table) {
            $table->id();
            $table->string('finix_id')->unique()->nullable();
            $table->timestamp('created_at', 0)->nullable();
            $table->timestamp('updated_at', 0)->nullable();
            $table->text('3ds_redirect_url')->nullable();
            $table->text('additional_buyer_charges')->nullable();
            $table->text('additional_healthcare_data')->nullable();
            $table->text('address_verification')->nullable();
            $table->decimal('amount', 10, 2)->nullable();
            $table->decimal('amount_requested', 10, 2)->nullable();
            $table->string('application')->nullable();
            $table->json('card_present_details')->nullable();
            $table->string('currency')->nullable();
            $table->string('device')->nullable();
            $table->timestamp('expires_at', 0)->nullable();
            $table->text('failure_code')->nullable();
            $table->text('failure_message')->nullable();
            $table->text('idempotency_id')->nullable();
            $table->boolean('is_void')->nullable();
            $table->string('merchant_identity')->nullable();
            $table->json('messages')->nullable();
            $table->json('raw')->nullable();
            $table->text('security_code_verification')->nullable();
            $table->string('source')->nullable();
            $table->string('state')->nullable();
            $table->json('tags')->nullable();
            $table->string('trace_id')->nullable();
            $table->text('transfer')->nullable();
            $table->string('void_state')->nullable();
            $table->timestamps();
             // New fields
             $table->string('api_key')->nullable();
             $table->boolean('is_live')->nullable();
             $table->integer('api_user')->nullable();
        });
        Schema::create('finix_disputes', function (Blueprint $table) {
            $table->id()->nullable();
            $table->string('finix_id')->nullable();
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
            $table->string('action')->nullable();
            $table->unsignedBigInteger('amount')->nullable();
            $table->string('application')->nullable();
            $table->json('dispute_details')->nullable();
            $table->string('identity')->nullable();
            $table->string('merchant')->nullable();
            $table->timestamp('occurred_at')->nullable();
            $table->string('reason')->nullable();
            $table->timestamp('respond_by')->nullable();
            $table->string('state')->nullable();
            $table->json('tags')->nullable();
            $table->string('transfer')->nullable();


            $table->timestamps();
             // New fields
             $table->string('api_key')->nullable();
             $table->boolean('is_live')->nullable();
             $table->integer('api_user')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('authorizations');
        Schema::dropIfExists('finix_disputes');
    }
}
