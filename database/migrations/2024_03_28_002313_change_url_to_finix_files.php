<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeUrlToFinixFiles extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('finix_external_links', function (Blueprint $table) {
            $table->text('url')->nullable()->change();
        });
        Schema::table('finix_external_links_live', function (Blueprint $table) {
            $table->text('url')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('finix_external_links', function (Blueprint $table) {
            $table->string('url')->nullable()->change();
        });
        Schema::table('finix_external_links_live', function (Blueprint $table) {
            $table->string('url')->nullable()->change();
        });
    }
}
