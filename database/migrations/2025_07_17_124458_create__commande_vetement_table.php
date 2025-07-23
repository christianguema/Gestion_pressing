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
            $table->id('commande_vetement_id');

            $table->unsignedBigInteger('commande_id');

            $table->unsignedBigInteger('vetement_id');

            $table->unsignedBigInteger('quantite')->nullable();

            $table->float('poids')->nullable();

            $table->timestamps();

            $table->foreign('commande_id')
                  ->references('commande_id')
                  ->on('commandes')
                  ->onDelete('cascade');

            $table->foreign('vetement_id')
                  ->references('vetement_id')
                  ->on('vetements')
                  ->onDelete('cascade');
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