<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddLiveToApiUser extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('api_users', function (Blueprint $table) {
            $table->boolean('live')->default(0)->nullable();
        });
        Schema::table('api_keys', function (Blueprint $table) {
            $table->integer('userID')->nullable();
        });
        Schema::table('users', function (Blueprint $table) {
            $table->boolean('live')->default(0)->nullable();
        });
        Schema::table('identities', function (Blueprint $table) {
            $table->boolean('isBuyer')->nullable();
            $table->boolean('isMerchant')->nullable();
        });
        Schema::table('identities_live', function (Blueprint $table) {
            $table->boolean('isBuyer')->nullable();
            $table->boolean('isMerchant')->nullable();
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
            $table->dropColumn('live');
        });
        Schema::table('api_keys', function (Blueprint $table) {
            $table->dropColumn('userID');
        });
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('live');
        });
        Schema::table('identities', function (Blueprint $table) {
            $table->dropColumn('isBuyer');
            $table->dropColumn('isMerchant');
        });
        Schema::table('identities_live', function (Blueprint $table) {
            $table->dropColumn('isBuyer');
            $table->dropColumn('isMerchant');
        });
    }
}
