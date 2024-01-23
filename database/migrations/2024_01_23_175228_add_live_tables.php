<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddLiveTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('authorizations_live', function (Blueprint $table) {
            $table->id();
            $table->string('finix_id')->unique()->nullable();
            $table->timestamp('finix_created_at', 0)->nullable();
            $table->timestamp('finix_updated_at', 0)->nullable();
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
        Schema::create('finix_disputes_live', function (Blueprint $table) {
            $table->id()->nullable();
            $table->string('finix_id')->nullable();
            $table->timestamp('finix_created_at')->nullable();
            $table->timestamp('finix_updated_at')->nullable();
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

        Schema::create('finix_balance_transfers_live', function (Blueprint $table) {
            $table->id();
            $table->string('finix_id')->unique();
            $table->timestamp('finix_created_at');
            $table->timestamp('finix_updated_at');
            $table->unsignedBigInteger('amount');
            $table->string('currency');
            $table->string('description');
            $table->string('destination');
            $table->string('external_reference_id');
            $table->string('processor_type');
            $table->string('reference_id');
            $table->string('source');
            $table->string('state');
            $table->json('tags')->nullable();
            $table->timestamps();
            $table->string('api_key')->nullable();
            $table->boolean('is_live')->nullable();
            $table->integer('api_user')->nullable();
        });
        Schema::create('finix_merchant_profiles_live', function (Blueprint $table) {
            $table->id();
            $table->string('finix_id')->unique();
            $table->timestamp('finix_created_at');
            $table->timestamp('finix_updated_at');
            $table->string('application');
            $table->string('fee_profile')->nullable();
            $table->string('payout_profile');
            $table->string('risk_profile');
            $table->json('tags');

            $table->timestamps();
        });
        Schema::create('finix_payout_profiles_live', function (Blueprint $table) {
            $table->id();
            $table->string('finix_id')->unique();
            $table->timestamp('finix_created_at');
            $table->timestamp('finix_updated_at');
            $table->string('linked_id');
            $table->string('linked_type');
            $table->json('gross');
            $table->json('tags');
            $table->string('type');
            $table->timestamps();
        });
        Schema::create('finix_verifications_live', function (Blueprint $table) {
            $table->id();
            $table->string('finix_id')->unique();
            $table->timestamp('finix_created_at');
            $table->timestamp('finix_updated_at');
            $table->string('application');
            $table->string('identity')->nullable();
            $table->string('merchant');
            $table->string('merchant_identity');
            $table->json('messages');
            $table->string('payment_instrument')->nullable();
            $table->string('processor');
            $table->string('raw');
            $table->string('state');
            $table->json('tags');
            $table->string('trace_id');

            $table->timestamps();
        });


        Schema::create('payment_ways_live', function (Blueprint $table) {
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
        Schema::create('settlements_live', function (Blueprint $table) {
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
        Schema::create('finix_users_live', function (Blueprint $table) {
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
        Schema::create('finix_payments_live', function (Blueprint $table) {
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
        Schema::create('finix_payment_links_live', function (Blueprint $table) {
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
        Schema::create('finix_checkout_forms_live', function (Blueprint $table) {
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
        Schema::create('finix_files_live', function (Blueprint $table) {
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
        Schema::create('finix_external_links_live', function (Blueprint $table) {
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
        Schema::create('finix_fee_profiles_live', function (Blueprint $table) {
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
        Schema::create('subscription_schedules_live', function (Blueprint $table) {
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
        Schema::create('subscription_amounts_live', function (Blueprint $table) {
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
        Schema::create('subscription_enrollments_live', function (Blueprint $table) {
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
        Schema::create('applications_live', function (Blueprint $table) {
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
        Schema::create('finix_merchants_live', function (Blueprint $table) {
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
        Schema::create('identities_live', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('application')->nullable();
            $table->json('entity')->nullable();
            $table->json('identity_roles')->nullable();
            $table->json('tags')->nullable();
            $table->text('_links')->nullable();

            // New fields
            $table->string('api_key')->nullable();
            $table->boolean('is_live')->nullable();
            $table->integer('api_user')->nullable();

        });
        Schema::table("finix_merchants_live",function(Blueprint $table){
            $table->integer('payments_count')->nullable();
            $table->string('finix_id')->unique()->nullable();
        });

        Schema::table("identities_live",function(Blueprint $table){
            $table->string('finix_id')->unique()->nullable();
            $table->integer('finix_merchant_id')->nullable();
            $table->integer('customer_id')->nullable();
        });
        Schema::table('finix_users_live', function (Blueprint $table) {
           $table->string('finix_id')->nullable();
        });

        Schema::create('pci_forms_live', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('finix_id');
            $table->timestamp('finix_created_at', 0);
            $table->timestamp('finix_updated_at', 0);
            $table->string('linked_to');
            $table->string('linked_type');
            $table->string('application');
            $table->string('type');
            $table->string('version');
            $table->timestamp('valid_from', 0);
            $table->timestamp('valid_until', 0);
            $table->json('tags');
            $table->json('pci_saq_a');
            $table->timestamp('due_at', 0);
            $table->string('compliance_form_template');
            $table->json('files');
            $table->string('state');
        });
        Schema::create('finix_application_profiles_live', function (Blueprint $table) {
            $table->id();
            $table->string('finix_id');
            $table->timestamp('finix_created_at');
            $table->timestamp('finix_updated_at');
            $table->string('application');
            $table->string('fee_profile');
            $table->string('risk_profile');
            $table->json('tags');
            $table->timestamps();
            $table->boolean('is_live')->nullable();
        });
        Schema::table('finix_application_profiles_live', function (Blueprint $table) {
            $table->string('finix_id')->nullable()->change();
            $table->timestamp('finix_created_at')->nullable()->change();
            $table->timestamp('finix_updated_at')->nullable()->change();
            $table->string('application')->nullable()->change();
            $table->string('fee_profile')->nullable()->change();
            $table->string('risk_profile')->nullable()->change();
            $table->json('tags')->nullable()->change();
        });
        Schema::table('finix_balance_transfers_live', function (Blueprint $table) {
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
        Schema::table('finix_merchant_profiles_live', function (Blueprint $table) {

            $table->string('finix_id')->nullable()->change();
            $table->timestamp('finix_created_at')->nullable()->change();
            $table->timestamp('finix_updated_at')->nullable()->change();
            $table->string('application')->nullable()->change();
            $table->string('payout_profile')->nullable()->change();
            $table->string('risk_profile')->nullable()->change();
            $table->json('tags')->nullable()->change();
        });
        Schema::table('finix_payout_profiles_live', function (Blueprint $table) {

            $table->string('finix_id')->nullable()->change();
            $table->timestamp('finix_created_at')->nullable()->change();
            $table->timestamp('finix_updated_at')->nullable()->change();
            $table->string('linked_id')->nullable()->change();
            $table->string('linked_type')->nullable()->change();
            $table->json('gross')->nullable()->change();
            $table->json('tags')->nullable()->change();
            $table->string('type')->nullable()->change();
        });
        Schema::table('finix_verifications_live', function (Blueprint $table) {
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
        Schema::table('pci_forms_live', function (Blueprint $table) {

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
        Schema::table('subscription_schedules_live', function (Blueprint $table) {
            $table->json('subscription_schedules')->nullable();
            $table->json('metadata')->nullable();
        });
        Schema::table('subscription_amounts_live', function (Blueprint $table) {
            $table->string('created_by')->nullable();
            $table->json('fee_amount_data')->nullable();
            $table->string('subscription_schedule')->nullable();
            $table->json('tags')->nullable();
        });
        Schema::table('subscription_enrollments_live', function (Blueprint $table) {
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
        Schema::dropIfExists('authorizations_live');
        Schema::dropIfExists('finix_disputes_live');
        Schema::dropIfExists('finix_balance_transfers_live');
        Schema::dropIfExists('finix_merchant_profiles_live');
        Schema::dropIfExists('finix_payout_profiles_live');
        Schema::dropIfExists('finix_verifications_live');
        Schema::dropIfExists('payment_ways_live');
        Schema::dropIfExists('settlements_live');
        Schema::dropIfExists('finix_users_live');
        Schema::dropIfExists('finix_payments_live');
        Schema::dropIfExists('finix_payment_links_live');
        Schema::dropIfExists('finix_checkout_forms_live');
        Schema::dropIfExists('finix_files_live');
        Schema::dropIfExists('finix_external_links_live');
        Schema::dropIfExists('finix_fee_profiles_live');
        Schema::dropIfExists('subscription_schedules_live');
        Schema::dropIfExists('subscription_amounts_live');
        Schema::dropIfExists('subscription_enrollments_live');
        Schema::dropIfExists('applications_live');
        Schema::dropIfExists('finix_merchants_live');
        Schema::dropIfExists('identities_live');
        Schema::dropIfExists('pci_forms_live');
        Schema::dropIfExists('finix_application_profiles_live');
    }
}
