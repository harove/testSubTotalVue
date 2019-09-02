<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnsToPlaylists extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('playlist', function (Blueprint $table) {
            $table->integer('testinit');
            $table->integer('testduration');
            $table->integer('testsubtotal');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('playlist', function (Blueprint $table) {
            $table->dropColumn('testinit');
            $table->dropColumn('testduration');
            $table->dropColumn('testsubtotal');
        });
    }
}
