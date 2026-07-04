<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('workout_logs', function (Blueprint $table) {
            $table->id();
            $table->unsignedSmallInteger('duration_minutes')->nullable();
            $table->timestamp('started_at');
            $table->timestamp('finished_at')->nullable();
            $table->foreignId('student_id')->constrained('students')->restrictOnDelete();
            $table->foreignId('training_sheet_id')->constrained('training_sheets')->restrictOnDelete();
            $table->foreignId('training_sheet_division_id')->constrained('training_sheet_divisions')->restrictOnDelete();
            $table->foreignId('validated_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();

            $table->index('student_id');
            $table->index('training_sheet_id');
            $table->index('training_sheet_division_id');
            $table->index('started_at');
            $table->index(['student_id', 'started_at']);
            $table->index(['training_sheet_id', 'started_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('workout_logs');
    }
};
