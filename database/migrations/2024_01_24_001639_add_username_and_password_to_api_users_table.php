<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddUsernameAndPasswordToApiUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('api_users', function (Blueprint $table) {
            $table->string('username_live')->nullable();
            $table->string('password_live')->nullable();
        });
        Schema::table('users', function (Blueprint $table) {
            $table->boolean('hasId')->default(0)->nullable();
            $table->boolean('hasId_live')->default(0)->nullable();
        });
        Schema::create('awaiting_user', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('identity')->default(0)->nullable();
            $table->integer('user_id')->nullable();
        });
        Schema::create('awaiting_user_live', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('identity')->nullable();
            $table->boolean('user_id')->nullable();
        });
        Schema::create('awaiting_pci', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('ip')->nullable();
            $table->string('browser')->nullable();
            $table->string('name')->nullable();
            $table->string('merchant_id')->nullable();
            $table->boolean('user_id')->nullable();
        });
        Schema::create('awaiting_pci_live', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('ip')->nullable();
            $table->string('browser')->nullable();
            $table->string('name')->nullable();
            $table->string('merchant_id')->nullable();
            $table->boolean('user_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('api_users', function (Blueprint $table) {
            $table->dropColumn('username_live');
            $table->dropColumn('password_live');
        });
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('hasId');
            $table->dropColumn('hasId_live');
        });
        Schema::dropIfExists('awaiting_user_live');
        Schema::dropIfExists('awaiting_pci');
        Schema::dropIfExists('awaiting_pci_live');
    }
}
