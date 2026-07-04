<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('workout_log_exercises', function (Blueprint $table) {
            $table->id();
            $table->string('performed_repetitions')->nullable();
            $table->text('observation')->nullable();
            $table->decimal('performed_load', 6, 2)->nullable();
            $table->unsignedTinyInteger('performed_series')->nullable();
            $table->boolean('completed')->default(false);
            $table->foreignId('workout_log_id')->constrained('workout_logs')->cascadeOnDelete();
            $table->foreignId('exercise_id')->constrained('exercises')->restrictOnDelete();
            $table->timestamps();

            $table->index('workout_log_id');
            $table->index('exercise_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('workout_log_exercises');
    }
};
