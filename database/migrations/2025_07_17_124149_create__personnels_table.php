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
        Schema::create('personnels', function (Blueprint $table) {
            
            $table->id('personnel_id');

            $table->string('poste')->nullable();

            $table->date('date_embauche')->nullable();

            $table->integer('pressing_id')->nullable(); 

            // $table->integer('gestionnaire_id');

            $table->timestamps();

           
            $table->foreign('pressing_id')
                  ->references('pressing_id')
                  ->on('pressings')
                  ->onDelete('cascade');

            // $table->foreign('gestionnaire_id')
            //       ->references('gestionnaire_id')
            //       ->on('gestionnaires')
            //       ->onDelete('cascade');

             $table->foreign('personnel_id')
                  ->references('id')
                  ->on('users')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('personnels');
    }
};