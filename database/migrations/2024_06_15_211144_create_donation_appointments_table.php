<?php

use App\Enums\AppointmentReason;
use App\Enums\Status\DonationAppointmentStatus;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('donation_appointments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->unsignedBigInteger('donation_match_id')->after('user_id');
            $table->foreign('donation_match_id')->references('id')->on('donation_matches')->onDelete('cascade');

            $table->unsignedBigInteger('donation_id');
            $table->foreign('donation_id')->references('id')->on('donations')->onDelete('cascade');

            $table->date('appointment_date');
            $table->time('appointment_time');
            $table->foreignId('location_id')->constrained('locations', 'id')->nullable();

            $table->enum('status', [Arr::map(DonationAppointmentStatus::cases(), fn($role) => $role->name)])->default(DonationAppointmentStatus::SCHEDULED->name);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('donation_appointments');
    }
};
