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
            $table->integer('commande_id');
            $table->decimal('montant', 10, 2);
            $table->date('date_paiement');
            $table->string('reference_transaction');
            $table->integer('mode_paiement_id');
            $table->foreign("mode_paiement_id")->references('mode_paiement_id')->on('mode')->cascadeOnDelete();
            $table->foreign('commande_id')->references('commande_id')->on('commandes')->cascadeOnDelete();
            $table->timestamps();
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
