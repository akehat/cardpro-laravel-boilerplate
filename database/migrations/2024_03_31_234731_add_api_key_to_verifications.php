<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddApiKeyToVerifications extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasColumn('finix_verifications', 'api_key')) {
            Schema::table('finix_verifications', function (Blueprint $table) {
                $table->string('api_key')->nullable();
            });
        }
        if (!Schema::hasColumn('finix_verifications_live', 'api_key')) {
            Schema::table('finix_verifications_live', function (Blueprint $table) {
                $table->string('api_key')->nullable();
            });
        }
        if (!Schema::hasColumn('finix_verifications', 'is_live')) {
            Schema::table('finix_verifications', function (Blueprint $table) {
                $table->boolean('is_live')->nullable();
            });
        }
        if (!Schema::hasColumn('finix_verifications_live', 'is_live')) {
            Schema::table('finix_verifications_live', function (Blueprint $table) {
                $table->boolean('is_live')->nullable();
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('pci_forms_live', function (Blueprint $table) {
            $table->dropColumn('api_key');
            $table->dropColumn('is_live');
        });
        Schema::table('pci_forms', function (Blueprint $table) {
            $table->dropColumn('api_key');
            $table->dropColumn('is_live');
        });
    }
}
