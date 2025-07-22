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
            $table->unsignedBigInteger('personnel_id')->primary();
            $table->string('poste');
            $table->date('date_embauche');
            $table->enum("sexe",["F","M"]);
            $table->integer('pressing_id');
            $table->foreign('pressing_id')->references('pressing_id')->on('pressings')->cascadeOnDelete();
            $table->foreign('personnel_id')->references('id')->on('users')->cascadeOnDelete();
            $table->timestamps();
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
