<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaymentWaysTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table("finix_merchants",function(Blueprint $table){
            $table->integer('payments_count')->nullable();
            $table->string('finix_id')->unique()->nullable();
        });

        Schema::table("identities",function(Blueprint $table){
            $table->string('finix_id')->unique()->nullable();
            $table->integer('finix_merchant_id')->nullable();
            $table->integer('customer_id')->nullable();
        });
        Schema::table("api_users",function(Blueprint $table){
            $table->integer('payments_count')->nullable();
            $table->integer('total')->nullable();
            $table->integer('user_id')->nullable();
            $table->string('username')->nullable();
            $table->string('password')->nullable();
        });
        Schema::create('payment_ways', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('finix_id')->unique()->nullable();
            $table->dateTime('created_at_finix')->nullable();
            $table->dateTime('updated_at_finix')->nullable();
            $table->string('application')->nullable();
            $table->string('created_via')->nullable();
            $table->string('currency')->nullable();
            $table->string('disabled_code')->nullable();
            $table->string('disabled_message')->nullable();
            $table->boolean('enabled')->nullable();
            $table->string('fingerprint')->nullable();
            $table->string('identity')->nullable();
            $table->string('instrument_type')->nullable();
            $table->string('address')->nullable();
            $table->string('address_verification')->nullable();
            $table->string('bin')->nullable();
            $table->string('brand')->nullable();
            $table->string('card_type')->nullable();
            $table->integer('expiration_month')->nullable();
            $table->integer('expiration_year')->nullable();
            $table->string('issuer_country')->nullable();
            $table->string('last_four')->nullable();
            $table->string('name')->nullable();
            $table->string('security_code_verification')->nullable();
            $table->string('tags')->nullable();
            $table->string('type')->nullable();
            $table->string('_links')->nullable();
            $table->string('account_type')->nullable();
            $table->string('bank_account_validation_check')->nullable();
            $table->string('bank_code')->nullable();
            $table->string('country')->nullable();
            $table->string('institution_number')->nullable();
            $table->string('masked_account_number')->nullable();
            $table->string('transit_number')->nullable();
            $table->string('api_key')->nullable();
            $table->boolean('is_live')->nullable();
            $table->integer('api_user')->nullable();
        });
        Schema::create('settlements', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('finix_id')->unique()->nullable();
            $table->dateTime('created_at_finix')->nullable();
            $table->dateTime('updated_at_finix')->nullable();
            $table->string('application')->nullable();
            $table->string('currency')->nullable();
            $table->string('destination')->nullable();
            $table->string('funds_flow')->nullable();
            $table->string('identity')->nullable();
            $table->string('merchant_id')->nullable();
            $table->integer('net_amount')->nullable();
            $table->string('payment_type')->nullable();
            $table->string('processor')->nullable();
            $table->string('status')->nullable();
            $table->string('tags')->nullable();
            $table->integer('total_amount')->nullable();
            $table->integer('total_fee')->nullable();
            $table->integer('total_fees')->nullable();
            $table->string('type')->nullable();
            $table->string('_links')->nullable();
            $table->string('api_key')->nullable();
            $table->boolean('is_live')->nullable();
            $table->integer('api_user')->nullable();
        });
        Schema::create('finix_users', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('created_by')->nullable();
            $table->boolean('enabled')->nullable();
            $table->string('identity')->nullable();
            $table->dateTime('last_used_date')->nullable();
            $table->string('password')->nullable();
            $table->string('role')->nullable();
            $table->string('tags')->nullable();
            $table->string('_links')->nullable();
        });
        Schema::create('finix_payments', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('finix_id')->unique()->nullable();
            $table->dateTime('created_at_finix')->nullable();
            $table->dateTime('updated_at_finix')->nullable();
            $table->string('additional_buyer_charges')->nullable();
            $table->string('additional_healthcare_data')->nullable();
            $table->string('additional_purchase_data')->nullable();
            $table->string('address_verification')->nullable();
            $table->integer('amount')->nullable();
            $table->integer('amount_requested')->nullable();
            $table->string('application')->nullable();
            $table->string('currency')->nullable();
            $table->string('destination')->nullable();
            $table->string('externally_funded')->nullable();
            $table->string('failure_code')->nullable();
            $table->string('failure_message')->nullable();
            $table->integer('fee')->nullable();
            $table->string('idempotency_id')->nullable();
            $table->string('merchant')->nullable();
            $table->string('merchant_identity')->nullable();
            $table->json('messages')->nullable();
            $table->string('parent_transfer')->nullable();
            $table->string('parent_transfer_trace_id')->nullable();
            $table->string('raw')->nullable();
            $table->dateTime('ready_to_settle_at')->nullable();
            $table->dateTime('receipt_last_printed_at')->nullable();
            $table->string('security_code_verification')->nullable();
            $table->string('source')->nullable();
            $table->json('split_transfers')->nullable();
            $table->string('state')->nullable();
            $table->string('statement_descriptor')->nullable();
            $table->string('subtype')->nullable();
            $table->string('tags')->nullable();
            $table->string('trace_id')->nullable();
            $table->string('type')->nullable();
            $table->string('_links')->nullable();
            $table->string('fee_type')->nullable();
            $table->string('api_key')->nullable();
            $table->boolean('is_live')->nullable();
            $table->integer('api_user')->nullable();
            $table->integer('merchant_id')->nullable();
            $table->integer('customer_id')->nullable();

            // Indexes
            $table->index('application')->nullable();
            $table->index('merchant_identity')->nullable();
            $table->index('source')->nullable();
        });
        Schema::create('finix_payment_links', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('finix_id')->unique()->nullable();
            $table->dateTime('created_at_finix')->nullable();
            $table->dateTime('updated_at_finix')->nullable();
            $table->string('application_id')->nullable();
            $table->string('merchant_id')->nullable();
            $table->string('payment_frequency')->nullable();
            $table->boolean('is_multiple_use')->nullable();
            $table->json('allowed_payment_methods')->nullable();
            $table->string('nickname')->nullable();
            $table->json('items')->nullable();
            $table->json('buyer_details')->nullable();
            $table->json('amount_details')->nullable();
            $table->json('branding')->nullable();
            $table->json('additional_details')->nullable();
            $table->string('state')->nullable();
            $table->json('tags')->nullable();
            $table->string('link_url')->nullable();
            $table->dateTime('link_expires_at')->nullable();
            $table->string('_links')->nullable();
            $table->string('api_key')->nullable();
            $table->boolean('is_live')->nullable();
            $table->integer('api_user')->nullable();
        });
        Schema::create('finix_checkout_forms', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('merchant_id')->nullable();
            $table->string('finix_id')->unique()->nullable();
            $table->string('payment_frequency')->nullable();
            $table->boolean('is_multiple_use')->nullable();
            $table->json('allowed_payment_methods')->nullable();
            $table->string('nickname')->nullable();
            $table->json('items')->nullable();
            $table->json('buyer')->nullable();
            $table->json('amount_details')->nullable();
            $table->json('branding')->nullable();
            $table->json('additional_details')->nullable();
            $table->string('api_key')->nullable();
            $table->boolean('is_live')->nullable();
            $table->integer('api_user')->nullable();
        });
        Schema::create('finix_files', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('file_id')->nullable();
            $table->string('finix_id')->unique()->nullable();
            $table->string('display_name')->nullable();
            $table->string('linked_to')->nullable();
            $table->string('linked_type')->nullable();
            $table->string('platform_id')->nullable();
            $table->string('status')->nullable();
            $table->json('tags')->nullable();
            $table->string('type')->nullable();
            $table->string('api_key')->nullable();
            $table->boolean('is_live')->nullable();
            $table->integer('api_user')->nullable();
        });
        Schema::create('finix_external_links', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('finix_id')->unique()->nullable();
            $table->string('link_id')->nullable();
            $table->dateTime('expires_at')->nullable();
            $table->string('file_id')->nullable();
            $table->string('type')->nullable();
            $table->string('url')->nullable();
            $table->string('user_id')->nullable();
            $table->string('api_key')->nullable();
            $table->boolean('is_live')->nullable();
            $table->integer('api_user')->nullable();
        });
        Schema::create('finix_fee_profiles', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            $table->string('finix_id')->unique()->nullable();
            $table->integer('ach_basis_points')->nullable();
            $table->decimal('ach_credit_return_fixed_fee', 10, 2)->nullable();
            $table->decimal('ach_debit_return_fixed_fee', 10, 2)->nullable();
            $table->decimal('ach_fixed_fee', 10, 2)->nullable();
            $table->decimal('american_express_assessment_basis_points', 10, 2)->nullable();
            $table->decimal('american_express_basis_points', 10, 2)->nullable();
            $table->decimal('american_express_charge_interchange', 10, 2)->nullable();
            $table->decimal('american_express_externally_funded_basis_points', 10, 2)->nullable();
            $table->decimal('american_express_externally_funded_fixed_fee', 10, 2)->nullable();
            $table->decimal('american_express_fixed_fee', 10, 2)->nullable();
            $table->decimal('ancillary_fixed_fee_primary', 10, 2)->nullable();
            $table->decimal('ancillary_fixed_fee_secondary', 10, 2)->nullable();
            $table->string('application')->nullable();
            $table->integer('basis_points')->nullable();
            $table->boolean('charge_interchange')->nullable();
            $table->decimal('diners_club_basis_points', 10, 2)->nullable();
            $table->decimal('diners_club_charge_interchange', 10, 2)->nullable();
            $table->decimal('diners_club_fixed_fee', 10, 2)->nullable();
            $table->decimal('discover_assessments_basis_points', 10, 2)->nullable();
            $table->decimal('discover_basis_points', 10, 2)->nullable();
            $table->decimal('discover_charge_interchange', 10, 2)->nullable();
            $table->decimal('discover_data_usage_fixed_fee', 10, 2)->nullable();
            $table->decimal('discover_externally_funded_basis_points', 10, 2)->nullable();
            $table->decimal('discover_externally_funded_fixed_fee', 10, 2)->nullable();
            $table->decimal('discover_fixed_fee', 10, 2)->nullable();
            $table->decimal('discover_network_authorization_fixed_fee', 10, 2)->nullable();
            $table->decimal('dispute_fixed_fee', 10, 2)->nullable();
            $table->decimal('dispute_inquiry_fixed_fee', 10, 2)->nullable();
            $table->decimal('externally_funded_basis_points', 10, 2)->nullable();
            $table->decimal('externally_funded_fixed_fee', 10, 2)->nullable();
            $table->decimal('fixed_fee', 10, 2)->nullable();
            $table->decimal('jcb_basis_points', 10, 2)->nullable();
            $table->decimal('jcb_charge_interchange', 10, 2)->nullable();
            $table->decimal('jcb_fixed_fee', 10, 2)->nullable();
            $table->decimal('mastercard_acquirer_fees_basis_points', 10, 2)->nullable();
            $table->decimal('mastercard_assessments_over1k_basis_points', 10, 2)->nullable();
            $table->decimal('mastercard_assessments_under1k_basis_points', 10, 2)->nullable();
            $table->decimal('mastercard_basis_points', 10, 2)->nullable();
            $table->decimal('mastercard_charge_interchange', 10, 2)->nullable();
            $table->decimal('mastercard_fixed_fee', 10, 2)->nullable();
            $table->json('qualified_tiers')->nullable();
            $table->enum('rounding_mode', ['TRANSACTION'])->nullable();
            $table->json('tags')->nullable();
            $table->decimal('visa_acquirer_processing_fixed_fee', 10, 2)->nullable();
            $table->decimal('visa_assessments_basis_points', 10, 2)->nullable();
            $table->decimal('visa_base_II_credit_voucher_fixed_fee', 10, 2)->nullable();
            $table->decimal('visa_base_II_system_file_transmission_fixed_fee', 10, 2)->nullable();
            $table->decimal('visa_basis_points', 10, 2)->nullable();
            $table->decimal('visa_charge_interchange', 10, 2)->nullable();
            $table->decimal('visa_credit_voucher_fixed_fee', 10, 2)->nullable();
            $table->decimal('visa_fixed_fee', 10, 2)->nullable();
            $table->decimal('visa_kilobyte_access_fixed_fee', 10, 2)->nullable();

            // Additional columns
            $table->string('api_key')->nullable();
            $table->boolean('is_live')->nullable();
            $table->integer('api_user')->nullable();
        });
        Schema::create('subscription_schedules', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            // Add other columns based on your needs
            $table->string('finix_id')->unique()->nullable();
            $table->string('nickname')->nullable();
            $table->string('line_item_type')->nullable();
            $table->string('subscription_type')->nullable();
            // Add more columns as needed

            // Foreign key to link with subscription amounts
            $table->string('api_key')->nullable();
            $table->boolean('is_live')->nullable();
            $table->integer('api_user')->nullable();
            $table->index('finix_id')->nullable();
        });
        Schema::create('subscription_amounts', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            // Add other columns based on your needs
            $table->string('finix_id')->unique()->nullable();
            $table->string('nickname')->nullable();
            $table->string('amount_type')->nullable();
            $table->decimal('amount')->nullable();
            $table->string('currency')->nullable();
            // Add more columns as needed
            $table->string('api_key')->nullable();
            $table->boolean('is_live')->nullable();
            $table->integer('api_user')->nullable();
            $table->index('finix_id')->nullable();
        });
        Schema::create('subscription_enrollments', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            // Add other columns based on your needs
            $table->string('finix_id')->unique()->nullable();
            $table->string('nickname')->nullable();
            $table->dateTime('started_at')->nullable();
            $table->dateTime('ended_at')->nullable();
            // Add more columns as needed

            $table->string('api_key')->nullable();
            $table->boolean('is_live')->nullable();
            $table->integer('api_user')->nullable();

            $table->index('finix_id')->nullable();
        });
        Schema::create('applications', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('finix_id')->unique()->nullable();
            $table->string('name')->nullable();
            $table->boolean('card_cvv_required')->nullable();
            $table->boolean('card_expiration_date_required')->nullable();
            $table->boolean('creating_transfer_from_report_enabled')->nullable();
            $table->boolean('enabled')->nullable();
            $table->string('fee_ready_to_settle_upon')->nullable();
            $table->string('owner')->nullable(); // This could be a foreign key reference to your users table
            $table->boolean('processing_enabled')->nullable();
            $table->string('ready_to_settle_upon')->nullable();
            $table->boolean('settlement_enabled')->nullable();
            $table->string('settlement_funding_identifier')->nullable();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('finix_users');
        Schema::dropIfExists('subscription_amounts');
        Schema::dropIfExists('finix_checkout_forms');
        Schema::dropIfExists('subscription_schedules');
        Schema::dropIfExists('subscription_enrollments');
        Schema::dropIfExists('finix_external_links');
        Schema::dropIfExists('finix_files');
        Schema::dropIfExists('finix_payments');
        Schema::dropIfExists('finix_payment_links');
        Schema::dropIfExists('payment_ways');
        Schema::dropIfExists('settlements');
        Schema::dropIfExists('applications');
        Schema::dropIfExists('finix_fee_profiles');
        Schema::table("finix_merchants",function(Blueprint $table){
            $table->dropColumn('payments_count');
            $table->dropColumn('finix_id');

        });
        Schema::table("api_users",function(Blueprint $table){
            $table->dropColumn('payments_count');
            $table->dropColumn('total');
            $table->dropColumn('user_id');
            $table->dropColumn('username');
            $table->dropColumn('password');
        });
        Schema::table("identities",function(Blueprint $table){
            $table->dropColumn('finix_id');
        });
    }
}

