<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('items', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('image_path')->nullable();
            $table->text('description')->nullable();
            $table->decimal('total_price', 10, 2);
            $table->decimal('promotion_price', 10, 2)->nullable();
            $table->foreignId('item_type_id')->constrained('item_types')->restrictOnDelete();
            $table->timestamps();
            $table->softDeletes();

            $table->index('item_type_id');
            $table->index('deleted_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('items');
    }
};
