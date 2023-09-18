<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddVehicleNumberToVisitorsTable extends Migration
{
    public function up()
    {
        Schema::table('visitors', function (Blueprint $table) {
            $table->string('vehicle_number');
        });
    }
    
    public function down()
    {
        Schema::table('visitors', function (Blueprint $table) {
            $table->dropColumn('vehicle_number');
        });
    }
}
