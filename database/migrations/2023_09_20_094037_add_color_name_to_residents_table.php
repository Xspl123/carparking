<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColorNameToResidentsTable extends Migration
{
    public function up()
    {
        Schema::table('residents', function (Blueprint $table) {
            $table->string('color_name')->nullable();
        });
    }

    public function down()
    {
        Schema::table('residents', function (Blueprint $table) {
            $table->dropColumn('color_name');
        });
    }
}
