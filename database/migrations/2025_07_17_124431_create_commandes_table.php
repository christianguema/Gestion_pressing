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
        Schema::create('commandes', function (Blueprint $table) {
            $table->id('commande_id');
            $table->unsignedBigInteger('client_id');
            $table->unsignedBigInteger('personnel_id');
            $table->unsignedBigInteger('type_prestation_id');
            $table->unsignedBigInteger('type_facturation_id');
            $table->unsignedBigInteger('pressing_id');
            $table->unsignedBigInteger('paiement_id');


            $table->date('date_reception');
            $table->date('date_livraison');
            $table->enum('etat',['En_attente', 'En_cours', 'Terminé', 'Annulé']);
            $table->decimal('montant_total', 10, 2)->nullable();


            $table->foreign('client_id')
                  ->references('client_id')
                  ->on('clients')
                  ->cascadeOnDelete();

            $table->foreign('personnel_id')
                  ->references('personnel_id')
                  ->on('personnels')
                  ->cascadeOnDelete();

            $table->foreign('type_prestation_id')
                  ->references('type_prestation_id')
                  ->on('type_prestations')
                  ->cascadeOnDelete();

            $table->foreign('type_facturation_id')
                  ->references('type_facturation_id')
                  ->on('type_facturations')
                  ->cascadeOnDelete();

            $table->foreign('paiement_id')
                  ->references('paiement_id')
                  ->on('paiements')
                  ->cascadeOnDelete();

            $table->foreign('pressing_id')
                  ->references('pressing_id')
                  ->on('pressings')
                  ->cascadeOnDelete();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //Schema::dropIfExists('commandes');
    }
};
