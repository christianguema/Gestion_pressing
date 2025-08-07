<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TypePrestation extends Model
{
    use HasFactory;

    protected $fillable = [
        'intitule',
        'duree_moyenne',
        'cout_par_kilo',
    ];

    protected $primaryKey = 'type_prestation_id';

    public function commandes(): HasMany
    {
        return $this->hasMany(Commande::class);
    }
}