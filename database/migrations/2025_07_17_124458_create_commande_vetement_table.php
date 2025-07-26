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
        Schema::create('commande_vetement', function (Blueprint $table) {
            $table->unsignedBigInteger('commande_id');
            $table->unsignedBigInteger('vetement_id');
            $table->integer('quantite')->nullable();
            $table->string('couleur_vetement')->nullable();
            $table->decimal('prix_unitaire', 8, 2)->nullable();
            $table->foreign('commande_id')->references('commande_id')->on('commandes')->cascadeOnDelete();
            $table->foreign('vetement_id')->references('vetement_id')->on('vetements')->cascadeOnDelete();
            $table->primary(['commande_id', 'vetement_id']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('commande_vetement');
    }
};
