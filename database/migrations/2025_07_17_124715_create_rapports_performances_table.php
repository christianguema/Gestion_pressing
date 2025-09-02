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

            $table->unsignedBigInteger('pressing_id');

            $table->date('periode');

            $table->decimal('revenus',10,2)->default(0);

            $table->integer('nombre_commande')->default(0);

            $table->foreign('pressing_id')
                  ->references('pressing_id')
                  ->on('pressings')
                  ->onDelete('cascade');

            $table->unique(['pressing_id', 'periode'], 'unique_pressing_periode');
            $table->timestamps();

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
