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
        Schema::create('paiements', function (Blueprint $table) {
            $table->id('paiement_id');
            $table->unsignedBigInteger('commande_id');
            $table->float('montant');
            $table->string('mode_paiement');
            $table->string('statut');
            $table->date('date_paiement');
            $table->string('reference_transaction');
            $table->string('facture');
            $table->timestamps();

            $table->foreign('commande_id')
                  ->references('commande_id')
                  ->on('commandes')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('paiements');
    }
};