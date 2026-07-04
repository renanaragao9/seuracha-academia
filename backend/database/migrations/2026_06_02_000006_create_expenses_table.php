<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('expenses', function (Blueprint $table) {
            $table->id();
            $table->string('type');
            $table->string('status');
            $table->text('description')->nullable();
            $table->date('date_maturity');
            $table->decimal('total_amount', 10, 2);
            $table->foreignId('expense_type_id')->constrained('expense_types')->restrictOnDelete();
            $table->foreignId('user_id')->constrained('users')->restrictOnDelete();
            $table->timestamps();
            $table->softDeletes();

            $table->index('expense_type_id');
            $table->index('user_id');
            $table->index('status');
            $table->index('date_maturity');
            $table->index('deleted_at');
            $table->index(['status', 'date_maturity']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('expenses');
    }
};
