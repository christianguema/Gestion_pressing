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
        Schema::create('vetements', function (Blueprint $table) {
            $table->id('vetement_id');
            $table->string('type');
            $table->float('prix_unitaire');
            $table->integer('categorie_id');
            $table->foreign('categorie_id')->references('categorie_id')->on('categories')->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vetements');
    }
};
