<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('assessment_items', function (Blueprint $table) {
            $table->id();
            $table->string('unit', 20)->nullable();
            $table->text('notes')->nullable();
            $table->decimal('value', 8, 2);
            $table->integer('order')->default(0);
            $table->foreignId('assessment_id')->constrained('assessments')->cascadeOnDelete();
            $table->foreignId('measurement_type_id')->constrained('measurement_types')->cascadeOnDelete();
            $table->timestamps();
            $table->softDeletes();

            $table->index('assessment_id');
            $table->index('measurement_type_id');
            $table->index('deleted_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('assessment_items');
    }
};
