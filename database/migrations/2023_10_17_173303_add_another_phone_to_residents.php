<?php


use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAnotherPhoneToResidents extends Migration
{
    public function up()
    {
        Schema::table('residents', function (Blueprint $table) {
            $table->string('another_phone')->after('phone')->nullable();
        });
    }

    public function down()
    {
        Schema::table('residents', function (Blueprint $table) {
            $table->dropColumn('another_phone');
        });
    }
}

