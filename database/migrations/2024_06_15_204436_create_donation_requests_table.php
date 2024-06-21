<?php

use App\Enums\Status\DonationRequestStatus;
use App\Enums\UrgencyLevel;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;
use Nette\Utils\Random;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('donation_requests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('blood_type');
            $table->string('code')->default(Str::upper(Random::generate()));
            $table->unsignedInteger('amount');
            $table->enum('urgency_level', [Arr::map(UrgencyLevel::cases(), fn($role) => $role->name)]);
            $table->text('notes')->nullable();
            $table->enum('status', [Arr::map(DonationRequestStatus::cases(), fn($role) => $role->name)])->default(DonationRequestStatus::PENDING->name);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('donation_requests');
    }
};
