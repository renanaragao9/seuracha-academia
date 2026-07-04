<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('exercises', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description')->nullable();
            $table->string('image_path')->nullable();
            $table->string('gif_path')->nullable();
            $table->string('video_path')->nullable();
            $table->boolean('is_active')->default(true);
            $table->foreignId('equipment_type_id')->constrained('equipment_types')->restrictOnDelete();
            $table->foreignId('muscle_group_id')->constrained('muscle_groups')->restrictOnDelete();
            $table->timestamps();
            $table->softDeletes();

            $table->index('equipment_type_id');
            $table->index('muscle_group_id');
            $table->index('is_active');
            $table->index('deleted_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('exercises');
    }
};
