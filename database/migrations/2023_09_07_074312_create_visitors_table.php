<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVisitorsTable extends Migration
{
    public function up()
    {
        Schema::create('visitors', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('resident_id');
            $table->string('name');
            $table->string('contact_phone')->nullable();
            $table->string('contact_email')->nullable();
            $table->string('vehicle_registration')->nullable();
            $table->text('purpose');
            $table->dateTime('check_in_time');
            $table->dateTime('check_out_time')->nullable();
            $table->enum('status', ['in', 'out'])->default('in');
            $table->string('photo_path')->nullable();
            $table->string('identification')->nullable();
            $table->text('additional_notes')->nullable();
            $table->unsignedBigInteger('approved_by')->nullable();
            $table->dateTime('appointment_datetime')->nullable();
            $table->string('access_pass')->nullable();
            $table->string('emergency_contact')->nullable();
            $table->string('company_organization')->nullable();
            $table->string('duration_of_visit')->nullable();
            $table->string('badge_pass_number')->nullable();
            $table->unsignedBigInteger('host_id');
            $table->enum('visitor_type', ['guest', 'vendor', 'contractor'])->default('guest');
            $table->string('sign_in_method')->nullable();
            $table->string('sign_out_method')->nullable();
            $table->timestamps();

            $table->foreign('resident_id')->references('id')->on('residents')->onDelete('cascade');
            $table->foreign('approved_by')->references('id')->on('users')->onDelete('set null');
            $table->foreign('host_id')->references('id')->on('residents')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('visitors');
    }
}

