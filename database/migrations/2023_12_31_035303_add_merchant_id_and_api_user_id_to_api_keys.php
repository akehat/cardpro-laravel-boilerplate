<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddMerchantIdAndApiUserIdToApiKeys extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('api_keys', function (Blueprint $table) {
            $table->integer('api_user')->nullable();
            $table->integer('merchant_id')->nullable();
            $table->integer('bank_id')->nullable();
            $table->decimal('balance', 10, 2)->nullable();
            $table->string('currency')->nullable();
            $table->json('identity')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('api_keys', function (Blueprint $table) {
            $table->dropColumn('api_user');
            $table->dropColumn('merchant_id');
            $table->dropColumn('balance');
            $table->dropColumn('currency');
            $table->dropColumn('identity');
        });
    }
}
