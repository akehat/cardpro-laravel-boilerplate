<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPciTitleToPciForm extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('awaiting_pci', function (Blueprint $table) {
            $table->string('pci_title')->nullable();
        });
        Schema::create('awaiting_pci_live', function (Blueprint $table) {
            $table->string('pci_title')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::create('awaiting_pci', function (Blueprint $table) {
            $table->dropColumn('pci_title');
        });
        Schema::create('awaiting_pci_live', function (Blueprint $table) {
            $table->dropColumn('pci_title');
        });
    }
}
