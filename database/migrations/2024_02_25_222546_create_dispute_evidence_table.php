<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDisputeEvidenceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dispute_evidence', function (Blueprint $table) {
            $table->id();
            $table->date('finix_created_at')->nullable();
            $table->date('finix_updated_at')->nullable();
            $table->string('application')->nullable();
            $table->string('dispute')->nullable();
            $table->string('identity')->nullable();
            $table->string('merchant')->nullable();
            $table->string('state')->nullable();
            $table->json('tags')->nullable();
            $table->string('api_key')->nullable();
            $table->boolean('is_live')->nullable();
            $table->integer('api_user')->nullable();
            $table->timestamps();
        });
        Schema::create('dispute_evidence_live', function (Blueprint $table) {
            $table->id();
            $table->date('finix_created_at')->nullable();
            $table->date('finix_updated_at')->nullable();
            $table->string('application')->nullable();
            $table->string('dispute')->nullable();
            $table->string('identity')->nullable();
            $table->string('merchant')->nullable();
            $table->string('state')->nullable();
            $table->json('tags')->nullable();
            $table->string('api_key')->nullable();
            $table->boolean('is_live')->nullable();
            $table->integer('api_user')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('dispute_evidence');
        Schema::dropIfExists('dispute_evidence_live');
    }
}
