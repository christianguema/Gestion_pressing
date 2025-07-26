<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Pressing extends Model
{
    use HasFactory;

    // Champs remplissables via l'assignation de masse
    protected $fillable = [
        'nom',
        'adresse',
    ];

    protected $primaryKey = 'pressing_id';


    /**
     * Relation avec les personnels :
     * Un pressing peut avoir plusieurs personnels.
     */
    public function personnels(): HasMany
    {
        return $this->hasMany(Personnel::class, 'pressing_id', 'pressing_id');
    }

    /**
     * Relation avec les commandes :
     * Un pressing peut traiter plusieurs commandes.
     */
    public function commandes(): HasMany
    {
        return $this->hasMany(Commande::class, 'pressing_id', 'pressing_id');
    }

    public function rapportPerformances(): HasMany
    {
        return $this->hasMany(RapportsPerformance::class, 'pressing_id', 'pressing_id');
    }
}