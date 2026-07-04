<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('meal_plan_templates', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description')->nullable();
            $table->string('goal')->nullable();
            $table->json('template_data');
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            $table->softDeletes();

            $table->index('goal');
            $table->index('is_active');
            $table->index('deleted_at');
            $table->index(['goal', 'is_active']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('meal_plan_templates');
    }
};
