<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('training_sheet_divisions', function (Blueprint $table) {
            $table->id();
            $table->unsignedSmallInteger('order')->default(1);
            $table->foreignId('training_sheet_id')->constrained('training_sheets')->cascadeOnDelete();
            $table->foreignId('training_division_id')->constrained('training_divisions')->restrictOnDelete();
            $table->timestamps();

            $table->index('training_sheet_id');
            $table->index('training_division_id');
            $table->index(['training_sheet_id', 'order']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('training_sheet_divisions');
    }
};
