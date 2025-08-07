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

            $table->integer('paiement_id')->nullable();

            $table->float('poids_total')->nullable();

            $table->decimal('prix_unitaire_kilo', 8, 0)->nullable();

            $table->unsignedBigInteger('pressing_id');

            $table->date('date_reception');

            $table->date('date_livraison');

            $table->enum('etat', ['En_attente', 'Livré', 'Terminé', 'Annulé', 'Non_livré']);
            
            $table->decimal('montant_total', 10, 0)->nullable();

            $table->timestamps();

            $table->foreign('client_id')
                  ->references('client_id')
                  ->on('clients')
                  ->onDelete('cascade');

            $table->foreign('personnel_id')
                  ->references('personnel_id')
                  ->on('personnels')
                  ->onDelete('cascade');

            $table->foreign('type_prestation_id')
                  ->references('type_prestation_id')
                  ->on('type_prestations')
                  ->onDelete('cascade');

            $table->foreign('type_facturation_id')
                  ->references('type_facturation_id')
                  ->on('type_facturations')
                  ->onDelete('cascade');

            $table->foreign('paiement_id')
                  ->references('paiement_id')
                  ->on('paiements')
                  ->onDelete('cascade');

            $table->foreign('pressing_id')
                  ->references('pressing_id')
                  ->on('pressings')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('commandes');
    }
};