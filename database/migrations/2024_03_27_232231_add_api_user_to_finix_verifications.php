<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddApiUserToFinixVerifications extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasColumn('finix_verifications', 'api_user')) {
            Schema::table('finix_verifications', function (Blueprint $table) {
                $table->integer('api_user')->nullable();
            });
        }
        if (!Schema::hasColumn('finix_verifications_live', 'api_user')) {
            Schema::table('finix_verifications_live', function (Blueprint $table) {
                $table->integer('api_user')->nullable();
            });
        }
        // if (!Schema::hasColumn('settlements', 'api_user')) {
        //     Schema::table('settlements', function (Blueprint $table) {
        //         $table->integer('api_userID')->nullable();
        //     });
        // }
        // if (!Schema::hasColumn('settlements', 'api_user')) {
        //     Schema::table('settlements_live', function (Blueprint $table) {
        //         $table->integer('api_userID')->nullable();
        //     });
        // }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('finix_verifications', function (Blueprint $table) {
            $table->dropColumn('api_user');
        });
        Schema::table('finix_verifications_live', function (Blueprint $table) {
            $table->dropColumn('api_user');
        });
        // Schema::table('settlements', function (Blueprint $table) {
        //     $table->dropColumn('api_user');
        // });
        // Schema::table('settlements_live', function (Blueprint $table) {
        //     $table->dropColumn('api_user');
        // });
    }
}
