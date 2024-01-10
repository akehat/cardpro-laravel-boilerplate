<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MakeMerchantsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('finix_merchants', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('application')->nullable();
            $table->boolean('card_cvv_required')->nullable();
            $table->boolean('card_expiration_date_required')->nullable();
            $table->boolean('convenience_charges_enabled')->nullable();
            $table->string('country')->nullable();
            $table->boolean('creating_transfer_from_report_enabled')->nullable();
            $table->json('currencies')->nullable();
            $table->boolean('default_partial_authorization_enabled')->nullable();
            $table->boolean('disbursements_ach_pull_enabled')->nullable();
            $table->boolean('disbursements_ach_push_enabled')->nullable();
            $table->boolean('disbursements_card_pull_enabled')->nullable();
            $table->boolean('disbursements_card_push_enabled')->nullable();
            $table->string('fee_ready_to_settle_upon')->nullable();
            $table->string('gateway')->nullable();
            $table->boolean('gross_settlement_enabled')->nullable();
            $table->string('identity')->nullable();
            $table->boolean('level_two_level_three_data_enabled')->nullable();
            $table->integer('mcc')->nullable();
            $table->string('merchant_name')->nullable();
            $table->string('merchant_profile')->nullable();
            $table->string('mid')->nullable();
            $table->string('onboarding_state')->nullable();
            $table->boolean('processing_enabled')->nullable();
            $table->string('processor')->nullable();
            $table->text('processor_details')->nullable();
            $table->string('ready_to_settle_upon')->nullable();
            $table->boolean('rent_surcharges_enabled')->nullable();
            $table->boolean('settlement_enabled')->nullable();
            $table->string('settlement_funding_identifier')->nullable();
            $table->boolean('surcharges_enabled')->nullable();
            $table->json('tags')->nullable();
            $table->string('verification')->nullable();
            $table->text('_links')->nullable();
            // New fields
            $table->string('api_key')->nullable();
            $table->integer('total')->nullable();
            $table->string('currency')->nullable();
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
        Schema::dropIfExists('merchants');
    }
}
