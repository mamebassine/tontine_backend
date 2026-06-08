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
        Schema::create('membre_tontines', function (Blueprint $table) {
    $table->id();

    $table->foreignId('tontine_id')
          ->constrained()
          ->onDelete('cascade');

    $table->foreignId('user_id')
          ->constrained()
          ->onDelete('cascade');

    $table->integer('position')->nullable();
    $table->enum('role', ['admin', 'membre'])->default('membre');
    $table->date('date_adhesion');
    $table->integer('ordre_passage')->nullable();

    $table->timestamps();
});

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('membre_tontines');
    }
};
