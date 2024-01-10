<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MakeIdentityTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('identities', function (Blueprint $table) {
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
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('identities');
    }
}
