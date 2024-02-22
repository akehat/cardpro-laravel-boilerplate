<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeToTextLinkUrl extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('finix_payment_links_live', function (Blueprint $table) {
            $table->text('link_url')->change();
        });
        Schema::table('finix_payment_links', function (Blueprint $table) {
            $table->text('link_url')->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('finix_payment_links_live', function (Blueprint $table) {
            $table->string('link_url')->change();
        });
        Schema::table('finix_payment_links', function (Blueprint $table) {
            $table->string('link_url')->change();
        });
    }
}
