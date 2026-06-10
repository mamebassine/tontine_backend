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

            // Tour concerné
            $table->foreignId('tour_id')
                  ->constrained()
                  ->onDelete('cascade');

            // Membre qui paie
            $table->foreignId('user_id')
                  ->constrained()
                  ->onDelete('cascade');

            // Montant payé
            $table->decimal('montant', 10, 2);

            // Date limite de paiement
            $table->date('date_limite');

            // Date réelle de paiement
            $table->date('date_paiement')->nullable();

            // Statut du paiement
            $table->enum('status', [
                'paye',
                'impaye',
                'en_retard'
            ])->default('impaye');

            // Référence de paiement (mobile money, cash, etc.)
            $table->string('reference_paiement')->nullable();

            $table->timestamps();

            // Empêcher doublon paiement pour un même tour
            $table->unique(['tour_id', 'user_id']);
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