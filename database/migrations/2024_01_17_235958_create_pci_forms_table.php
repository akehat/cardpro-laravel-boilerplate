<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePciFormsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pci_forms', function (Blueprint $table) {
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
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pci_forms');
    }
}
