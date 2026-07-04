<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('monthly_fees', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->string('status', 20)->default('pending');
            $table->date('date_payment')->nullable();
            $table->date('start_date');
            $table->date('end_date');
            $table->decimal('full_payment', 8, 2);
            $table->decimal('discount_payment', 8, 2)->nullable();
            $table->decimal('amount_paid', 8, 2)->nullable();
            $table->foreignId('student_id')->constrained('students')->restrictOnDelete();
            $table->foreignId('payment_type_id')->constrained('payment_types')->restrictOnDelete();
            $table->foreignId('plan_type_id')->constrained('plan_types')->restrictOnDelete();
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
            $table->softDeletes();

            $table->index('uuid');
            $table->index('student_id');
            $table->index('payment_type_id');
            $table->index('plan_type_id');
            $table->index('start_date');
            $table->index('end_date');
            $table->index('deleted_at');
            $table->index(['student_id', 'start_date']);
            $table->index(['student_id', 'end_date']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('monthly_fees');
    }
};
