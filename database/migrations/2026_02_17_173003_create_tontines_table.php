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
        Schema::create('tontines', function (Blueprint $table) {
    $table->id();
    $table->string('nom');
    $table->text('description')->nullable();
    $table->decimal('montant_cotisation', 10, 2);
    $table->enum('frequence', ['journalier', 'hebdo', 'mensuel']);
    $table->integer('nombre_membres');
    $table->date('date_debut');
    $table->date('date_fin')->nullable();
    $table->enum('status', ['ouverte', 'en_cours', 'terminee'])->default('ouverte');
    $table->timestamps();
});
 
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tontines');
    }
};
