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

            // Tontine concernée
            $table->foreignId('tontine_id')
                  ->constrained()
                  ->onDelete('cascade');

            // Numéro du tour (1, 2, 3...)
            $table->integer('numero_tour');

            // Date du tour
            $table->date('date_tour');

            // Qui reçoit l’argent ce tour
            $table->foreignId('beneficiaire_id')
                  ->constrained('users')
                  ->onDelete('cascade');

            // Montant reçu
            $table->decimal('montant_recu', 10, 2)->default(0);

            // Statut du tour
            $table->enum('status', [
                'en_attente',
                'en_cours',
                'termine'
            ])->default('en_attente');

            $table->boolean('est_paye')->default(false);

            $table->timestamps();

            // Un seul tour par numéro dans une tontine
            $table->unique(['tontine_id', 'numero_tour']);
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