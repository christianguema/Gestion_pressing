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
        Schema::create('rapports_performances', function (Blueprint $table) {
            
            $table->id('rapport_performance_id');

            $table->integer('gestionnaire_id');

            $table->date('periode');

            $table->float('revenus');

            $table->integer('nombre_commande');

            // $table->string('satisfaction_client');

            $table->integer('pressing_id');

            $table->timestamps();

            $table->foreign('gestionnaire_id')
                  ->references('gestionnaire_id')
                  ->on('gestionnaires')
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
        Schema::dropIfExists('rapports_performances');
    }
};