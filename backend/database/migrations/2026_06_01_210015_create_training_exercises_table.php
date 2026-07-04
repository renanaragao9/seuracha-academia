<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('training_exercises', function (Blueprint $table) {
            $table->id();

            $table->string('repetitions')->default('10');
            $table->text('observation')->nullable();
            $table->decimal('load', 6, 2)->nullable();
            $table->unsignedSmallInteger('rest_seconds')->nullable();
            $table->unsignedTinyInteger('series')->default(3);
            $table->unsignedSmallInteger('order')->default(1);
            $table->foreignId('training_sheet_division_id')->constrained('training_sheet_divisions')->restrictOnDelete();
            $table->foreignId('exercise_id')->constrained('exercises')->restrictOnDelete();
            $table->timestamps();

            $table->index('training_sheet_division_id');
            $table->index('exercise_id');
            $table->index(['training_sheet_division_id', 'order']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('training_exercises');
    }
};
