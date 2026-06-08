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
       Schema::create('cotisations', function (Blueprint $table) {
    $table->id();

    $table->decimal('montant', 10, 2);
    $table->date('date_limite');

    $table->enum('status', ['paye', 'impaye', 'en_retard'])
          ->default('impaye');

    $table->foreignId('tour_id')
          ->constrained()
          ->onDelete('cascade');

    $table->foreignId('user_id')
          ->constrained()
          ->onDelete('cascade');

    $table->timestamps();
});

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cotisations');
    }
};
