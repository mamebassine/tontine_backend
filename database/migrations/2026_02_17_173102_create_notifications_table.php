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
        Schema::create('notifications', function (Blueprint $table) {
            $table->id();

            // Utilisateur concerné
            $table->foreignId('user_id')
                  ->constrained()
                  ->onDelete('cascade');

            // Contenu de la notification
            $table->string('titre');
            $table->text('message');

            // Type de notification
            $table->enum('type', [
                'paiement',
                'invitation',
                'rappel',
                'information'
            ]);

            // Statut de lecture
            $table->boolean('lu')->default(false);

            // Lien vers une tontine (optionnel mais utile)
            $table->foreignId('tontine_id')
                  ->nullable()
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
        Schema::dropIfExists('notifications');
    }
};