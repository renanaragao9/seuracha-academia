<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('item_field_type', function (Blueprint $table) {
            $table->id();
            $table->text('value');
            $table->foreignId('item_id')->constrained('items')->cascadeOnDelete();
            $table->foreignId('field_type_id')->constrained('field_types')->cascadeOnDelete();
            $table->timestamps();
            $table->softDeletes();

            $table->index('item_id');
            $table->index('field_type_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('item_field_type');
    }
};
