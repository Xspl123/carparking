<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddResidentIdToQrCodes extends Migration
{
    public function up()
    {
        Schema::table('qr_codes', function (Blueprint $table) {
            $table->unsignedBigInteger('resident_id')->nullable();
            $table->foreign('resident_id')->references('id')->on('residents')->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::table('qr_codes', function (Blueprint $table) {
            $table->dropForeign(['resident_id']);
            $table->dropColumn('resident_id');
        });
    }
}

