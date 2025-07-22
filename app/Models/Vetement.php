<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Vetement extends Model
{
    use HasFactory;

    protected $fillable = [
        'type',
        'prix_unitaire',
        'categorie_id',
    ];


    protected $primaryKey = 'vetement_id';

    public function categorie(): BelongsTo
    {
        return $this->belongsTo(Categorie::class);
    }

    public function commandes(): BelongsToMany
    {
        return $this->belongsToMany(Commande::class)->using(CommandeVetement::class)->withPivot(['quantite', 'poids']);
    }
}
