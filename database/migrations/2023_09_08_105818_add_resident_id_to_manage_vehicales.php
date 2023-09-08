<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddResidentIdToManageVehicales extends Migration
{
    public function up()
    {
        Schema::table('manage_vehicales', function (Blueprint $table) {
            $table->unsignedBigInteger('resident_id')->nullable();

            // Define a foreign key constraint if necessary
           $table->foreign('resident_id')->references('id')->on('residents')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::table('manage_vehicales', function (Blueprint $table) {
            $table->dropColumn('resident_id');
        });
    }
}

