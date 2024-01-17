<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ConnectUsernameAndPasswordToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('finix_users', function (Blueprint $table) {
           $table->string('finix_id')->nullable();
        });
        Schema::table('users', function (Blueprint $table) {
            $table->string('api_key')->nullable();
            $table->string('api_users_id')->nullable();
        });
        Schema::table('api_users', function (Blueprint $table) {
            $table->integer('userID')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('api_key');
            $table->dropColumn('api_users_id');
        });
        Schema::create('api_users', function (Blueprint $table) {
            $table->dropColumn('userID');
        });
        Schema::table('finix_users', function (Blueprint $table) {
            $table->dropColumn('finix_id');
         });
    }
}
