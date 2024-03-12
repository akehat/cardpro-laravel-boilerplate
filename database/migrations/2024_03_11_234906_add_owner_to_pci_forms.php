<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddOwnerToPciForms extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasColumn('pci_forms_live', 'api_key')) {
            Schema::table('pci_forms_live', function (Blueprint $table) {
                $table->string('api_key')->nullable();
            });
        }

        // Check if 'is_live' column exists in 'pci_forms_live' table
        if (!Schema::hasColumn('pci_forms_live', 'is_live')) {
            Schema::table('pci_forms_live', function (Blueprint $table) {
                $table->boolean('is_live')->nullable();
            });
        }

        // Check if 'api_user' column exists in 'pci_forms_live' table
        if (!Schema::hasColumn('pci_forms_live', 'api_user')) {
            Schema::table('pci_forms_live', function (Blueprint $table) {
                $table->integer('api_user')->nullable();
            });
        }

        // Check if 'api_key' column exists in 'pci_forms' table
        if (!Schema::hasColumn('pci_forms', 'api_key')) {
            Schema::table('pci_forms', function (Blueprint $table) {
                $table->string('api_key')->nullable();
            });
        }

        // Check if 'is_live' column exists in 'pci_forms' table
        if (!Schema::hasColumn('pci_forms', 'is_live')) {
            Schema::table('pci_forms', function (Blueprint $table) {
                $table->boolean('is_live')->nullable();
            });
        }

        // Check if 'api_user' column exists in 'pci_forms' table
        if (!Schema::hasColumn('pci_forms', 'api_user')) {
            Schema::table('pci_forms', function (Blueprint $table) {
                $table->integer('api_user')->nullable();
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
            $table->dropColumn('api_user');
        });
        Schema::table('pci_forms', function (Blueprint $table) {
            $table->dropColumn('api_key');
            $table->dropColumn('is_live');
            $table->dropColumn('api_user');
        });
    }
}
