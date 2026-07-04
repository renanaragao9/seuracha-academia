<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('training_sheets', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->boolean('is_active')->default(true);
            $table->foreignId('student_id')->constrained('students')->restrictOnDelete();
            $table->foreignId('created_by')->constrained('users')->restrictOnDelete();
            $table->foreignId('updated_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
            $table->softDeletes();

            $table->index('student_id');
            $table->index('created_by');
            $table->index('is_active');
            $table->index('deleted_at');
            $table->index(['student_id', 'is_active']);
            $table->index(['student_id', 'start_date']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('training_sheets');
    }
};
