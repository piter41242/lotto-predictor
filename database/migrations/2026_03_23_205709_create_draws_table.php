<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('draws', function (Blueprint $table) {
            $table->id();
            $table->foreignId('lottery_id')->constrained()->onDelete('cascade');
            $table->date('draw_date');
            $table->string('draw_number')->nullable();
            $table->text('results'); // <-- Cambiado de json a text
            $table->timestamps();
            
            $table->index(['lottery_id', 'draw_date']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('draws');
    }
};