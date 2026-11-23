<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('fish_seed_sizes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('fish_seed_id')->constrained('fish_seeds')->cascadeOnDelete();
            $table->string('size_label');
            $table->decimal('price', 12, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fish_seed_sizes');
    }
};
