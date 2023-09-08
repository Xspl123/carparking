<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddUrlToQrCodes extends Migration
{
    public function up()
    {
        Schema::table('qr_codes', function (Blueprint $table) {
            $table->string('url')->nullable();
        });
    }

    public function down()
    {
        Schema::table('qr_codes', function (Blueprint $table) {
            $table->dropColumn('url');
        });
    }
}

