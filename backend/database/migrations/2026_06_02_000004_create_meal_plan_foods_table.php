<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('meal_plan_foods', function (Blueprint $table) {
            $table->id();
            $table->string('unit')->nullable();
            $table->text('observation')->nullable();
            $table->decimal('quantity', 8, 2)->nullable();
            $table->unsignedSmallInteger('order')->default(1);
            $table->foreignId('meal_plan_meal_id')->constrained('meal_plan_meals')->cascadeOnDelete();
            $table->foreignId('food_id')->constrained('foods')->restrictOnDelete();
            $table->timestamps();

            $table->index('meal_plan_meal_id');
            $table->index('food_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('meal_plan_foods');
    }
};
