<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->string('status');
            $table->text('description')->nullable();
            $table->string('full_addresses');
            $table->timestamp('start_date');
            $table->timestamp('end_date');
            $table->integer('vacancies')->default(0);
            $table->foreignId('booking_type_id')->constrained('booking_types')->restrictOnDelete();
            $table->foreignId('user_id')->constrained('users')->restrictOnDelete();
            $table->timestamps();
            $table->softDeletes();

            $table->index('booking_type_id');
            $table->index('user_id');
            $table->index('status');
            $table->index('start_date');
            $table->index('end_date');
            $table->index('deleted_at');
            $table->index(['status', 'start_date']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};
