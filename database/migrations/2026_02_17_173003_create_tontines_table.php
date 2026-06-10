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

            // Infos générales
            $table->string('nom');
            $table->text('description')->nullable();

            // Code d'accès à la tontine
            $table->string('code')->unique();

            // Créateur de la tontine
            $table->foreignId('createur_id')
                  ->constrained('users')
                  ->onDelete('cascade');

            // Paramètres financiers
            $table->decimal('montant_cotisation', 10, 2);
            $table->decimal('penalite_retard', 10, 2)->default(0);

            // Organisation
            $table->enum('frequence', [
                'journalier',
                'hebdo',
                'mensuel'
            ]);

            $table->integer('nombre_max_membres');
            // Suivi
            $table->integer('tour_actuel')->default(1);

            // Dates
            $table->date('date_debut');
            $table->date('date_fin')->nullable();

            // Statut
            $table->enum('status', [
                'ouverte',
                'en_cours',
                'terminee',
                'annulee'
            ])->default('ouverte');

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