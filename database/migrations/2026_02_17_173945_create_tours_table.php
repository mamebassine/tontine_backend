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
        Schema::create('tours', function (Blueprint $table) {
    $table->id();

    $table->foreignId('tontine_id')
          ->constrained()
          ->onDelete('cascade');

    $table->integer('numero_tour');
    $table->date('date_tour');
    $table->boolean('est_paye')->default(false);

    $table->timestamps();
});

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tours');
    }
};
