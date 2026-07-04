<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('meal_plan_meals', function (Blueprint $table) {
            $table->id();
            $table->unsignedSmallInteger('order')->default(1);
            $table->foreignId('meal_plan_id')->constrained('meal_plans')->cascadeOnDelete();
            $table->foreignId('meal_type_id')->constrained('meal_types')->restrictOnDelete();
            $table->timestamps();

            $table->index('meal_plan_id');
            $table->index('meal_type_id');
            $table->index(['meal_plan_id', 'order']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('meal_plan_meals');
    }
};
