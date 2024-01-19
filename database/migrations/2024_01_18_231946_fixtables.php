<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Fixtables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('finix_application_profiles', function (Blueprint $table) {
            $table->string('finix_id')->nullable()->change();
            $table->timestamp('finix_created_at')->nullable()->change();
            $table->timestamp('finix_updated_at')->nullable()->change();
            $table->string('application')->nullable()->change();
            $table->string('fee_profile')->nullable()->change();
            $table->string('risk_profile')->nullable()->change();
            $table->json('tags')->nullable()->change();
        });
        Schema::table('finix_balance_transfers', function (Blueprint $table) {
            $table->string('finix_id')->nullable()->change();
            $table->timestamp('finix_created_at')->nullable()->change();
            $table->timestamp('finix_updated_at')->nullable()->change();
            $table->unsignedBigInteger('amount')->nullable()->change();
            $table->string('currency')->nullable()->change();
            $table->string('description')->nullable()->change();
            $table->string('destination')->nullable()->change();
            $table->string('external_reference_id')->nullable()->change();
            $table->string('processor_type')->nullable()->change();
            $table->string('reference_id')->nullable()->change();
            $table->string('source')->nullable()->change();
            $table->string('state')->nullable()->change();
        });
        Schema::table('finix_merchant_profiles', function (Blueprint $table) {

            $table->string('finix_id')->nullable()->change();
            $table->timestamp('finix_created_at')->nullable()->change();
            $table->timestamp('finix_updated_at')->nullable()->change();
            $table->string('application')->nullable()->change();
            $table->string('payout_profile')->nullable()->change();
            $table->string('risk_profile')->nullable()->change();
            $table->json('tags')->nullable()->change();
        });
        Schema::table('finix_payout_profiles', function (Blueprint $table) {

            $table->string('finix_id')->nullable()->change();
            $table->timestamp('finix_created_at')->nullable()->change();
            $table->timestamp('finix_updated_at')->nullable()->change();
            $table->string('linked_id')->nullable()->change();
            $table->string('linked_type')->nullable()->change();
            $table->json('gross')->nullable()->change();
            $table->json('tags')->nullable()->change();
            $table->string('type')->nullable()->change();
        });
        Schema::table('finix_verifications', function (Blueprint $table) {
            $table->string('finix_id')->nullable()->change();
            $table->timestamp('finix_created_at')->nullable()->change();
            $table->timestamp('finix_updated_at')->nullable()->change();
            $table->string('application')->nullable()->change();
            $table->string('merchant')->nullable()->change();
            $table->string('merchant_identity')->nullable()->change();
            $table->json('messages')->nullable()->change();
            $table->string('processor')->nullable()->change();
            $table->string('raw')->nullable()->change();
            $table->string('state')->nullable()->change();
            $table->json('tags')->nullable()->change();
            $table->string('trace_id')->nullable()->change();

        });
        Schema::table('pci_forms', function (Blueprint $table) {

            $table->string('finix_id')->nullable()->change();
            $table->timestamp('finix_created_at', 0)->nullable()->change();
            $table->timestamp('finix_updated_at', 0)->nullable()->change();
            $table->string('linked_to')->nullable()->change();
            $table->string('linked_type')->nullable()->change();
            $table->string('application')->nullable()->change();
            $table->string('type')->nullable()->change();
            $table->string('version')->nullable()->change();
            $table->timestamp('valid_from', 0)->nullable()->change();
            $table->timestamp('valid_until', 0)->nullable()->change();
            $table->json('tags')->nullable()->change();
            $table->json('pci_saq_a')->nullable()->change();
            $table->timestamp('due_at', 0)->nullable()->change();
            $table->string('compliance_form_template')->nullable()->change();
            $table->json('files')->nullable()->change();
            $table->string('state')->nullable()->change();
            $table->boolean('is_live')->nullable();
        });
        Schema::table('subscription_schedules', function (Blueprint $table) {
            $table->json('subscription_schedules')->nullable();
            $table->json('metadata')->nullable();
        });
        Schema::table('subscription_amounts', function (Blueprint $table) {
            $table->string('created_by')->nullable();
            $table->json('fee_amount_data')->nullable();
            $table->string('subscription_schedule')->nullable();
            $table->json('tags')->nullable();
        });
        Schema::table('subscription_enrollments', function (Blueprint $table) {
            $table->string('created_by')->nullable();
            $table->string('merchant')->nullable();
            $table->string('subscription_schedule')->nullable();
            $table->json('tags')->nullable();
        });
    }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('finix_application_profiles', function (Blueprint $table) {
            $table->string('finix_id')->nullable(false)->change();
            $table->timestamp('finix_created_at')->nullable(false)->change();
            $table->timestamp('finix_updated_at')->nullable(false)->change();
            $table->string('application')->nullable(false)->change();
            $table->string('fee_profile')->nullable(false)->change();
            $table->string('risk_profile')->nullable(false)->change();
            $table->json('tags')->nullable(false)->change();
        });

        Schema::table('finix_balance_transfers', function (Blueprint $table) {
            $table->string('finix_id')->unique()->nullable(false)->change();
            $table->timestamp('finix_created_at')->nullable(false)->change();
            $table->timestamp('finix_updated_at')->nullable(false)->change();
            $table->unsignedBigInteger('amount')->nullable(false)->change();
            $table->string('currency')->nullable(false)->change();
            $table->string('description')->nullable(false)->change();
            $table->string('destination')->nullable(false)->change();
            $table->string('external_reference_id')->nullable(false)->change();
            $table->string('processor_type')->nullable(false)->change();
            $table->string('reference_id')->nullable(false)->change();
            $table->string('source')->nullable(false)->change();
            $table->string('state')->nullable(false)->change();
        });

        Schema::table('finix_merchant_profiles', function (Blueprint $table) {
            $table->string('finix_id')->unique()->nullable(false)->change();
            $table->timestamp('finix_created_at')->nullable(false)->change();
            $table->timestamp('finix_updated_at')->nullable(false)->change();
            $table->string('application')->nullable(false)->change();
            $table->string('payout_profile')->nullable(false)->change();
            $table->string('risk_profile')->nullable(false)->change();
            $table->json('tags')->nullable(false)->change();
        });

        Schema::table('finix_payout_profiles', function (Blueprint $table) {
            $table->string('finix_id')->unique()->nullable(false)->change();
            $table->timestamp('finix_created_at')->nullable(false)->change();
            $table->timestamp('finix_updated_at')->nullable(false)->change();
            $table->string('linked_id')->nullable(false)->change();
            $table->string('linked_type')->nullable(false)->change();
            $table->json('gross')->nullable(false)->change();
            $table->json('tags')->nullable(false)->change();
            $table->string('type')->nullable(false)->change();
        });

        Schema::table('finix_verifications', function (Blueprint $table) {
            $table->dropColumn(['id', 'finix_id', 'finix_created_at', 'finix_updated_at', 'application', 'merchant', 'merchant_identity', 'messages', 'processor', 'raw', 'state', 'tags', 'trace_id']);
        });

        Schema::table('pci_forms', function (Blueprint $table) {
            $table->string('finix_id')->nullable(false)->change();
            $table->timestamp('finix_created_at', 0)->nullable(false)->change();
            $table->timestamp('finix_updated_at', 0)->nullable(false)->change();
            $table->string('linked_to')->nullable(false)->change();
            $table->string('linked_type')->nullable(false)->change();
            $table->string('application')->nullable(false)->change();
            $table->string('type')->nullable(false)->change();
            $table->string('version')->nullable(false)->change();
            $table->timestamp('valid_from', 0)->nullable(false)->change();
            $table->timestamp('valid_until', 0)->nullable(false)->change();
            $table->json('tags')->nullable(false)->change();
            $table->json('pci_saq_a')->nullable(false)->change();
            $table->timestamp('due_at', 0)->nullable(false)->change();
            $table->string('compliance_form_template')->nullable(false)->change();
            $table->json('files')->nullable(false)->change();
            $table->string('state')->nullable(false)->change();
            $table->boolean('is_live')->nullable(false)->change();
        });

        Schema::table('subscription_schedules', function (Blueprint $table) {
            $table->dropColumn(['subscription_schedules', 'metadata']);
        });

        Schema::table('subscription_amounts', function (Blueprint $table) {
            $table->dropColumn(['created_by', 'fee_amount_data', 'subscription_schedule', 'tags']);
        });

        Schema::table('subscription_enrollments', function (Blueprint $table) {
            $table->dropColumn(['created_by', 'merchant', 'subscription_schedule', 'tags']);
        });
    }

}
