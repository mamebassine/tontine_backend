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

            // Relation tontine
            $table->foreignId('tontine_id')
                  ->constrained()
                  ->onDelete('cascade');

            // Relation utilisateur
            $table->foreignId('user_id')
                  ->constrained()
                  ->onDelete('cascade');

            // Rôle dans la tontine
            $table->enum('role', [
                'createur',
                'admin',
                'membre'
            ])->default('membre');

            // Statut du membre
            $table->enum('status', [
                'actif',
                'suspendu',
                'exclu'
            ])->default('actif');

            // Ordre de passage dans la tontine
            $table->integer('ordre_passage')->nullable();

            // Date d’adhésion
            $table->date('date_adhesion');

            // Date de sortie (optionnel)
            $table->date('date_sortie')->nullable();

            $table->timestamps();

            // Un utilisateur ne peut pas rejoindre 2 fois la même tontine
            $table->unique(['tontine_id', 'user_id']);
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