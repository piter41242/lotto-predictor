<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('predictions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('lottery_id')->constrained()->onDelete('cascade');
            $table->text('predicted_numbers'); // <-- Cambiado de json a text
            $table->text('algorithm_metadata')->nullable(); // <-- Cambiado de json a text
            $table->timestamps();
            
            $table->index(['user_id', 'created_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('predictions');
    }
};