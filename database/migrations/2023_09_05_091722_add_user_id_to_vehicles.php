<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddUserIdToVehicles extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
{
    Schema::table('vehicles', function (Blueprint $table) {
        $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('cascade')->onUpdate('cascade');
        
    });
}

public function down()
{
    Schema::table('vehicles', function (Blueprint $table) {
        $table->dropForeign(['user_id']); // Drop the foreign key constraint
        $table->dropColumn('user_id'); // Drop the user_id column
    });
}
}
