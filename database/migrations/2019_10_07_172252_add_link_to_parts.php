<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddLinkToParts extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('parts', function (Blueprint $table) {
            $table->string('link', 255)->nullable()->after('slug');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('parts', function (Blueprint $table) {
            $table->dropColumn('link');
        });
    }
}
