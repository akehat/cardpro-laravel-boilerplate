<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeUrlToFinixFilesTake2 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('finix_external_links', function (Blueprint $table) {
            $table->text('url')->change();
        });
        Schema::table('finix_external_links_live', function (Blueprint $table) {
            $table->text('url')->change();
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
            $table->string('url')->change();
        });
        Schema::table('finix_external_links_live', function (Blueprint $table) {
            $table->string('url')->change();
        });
    }
}
