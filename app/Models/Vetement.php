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

    protected $table = 'vetements';
    protected $primaryKey = 'vetement_id';

    public function categorie(): BelongsTo
    {
        return $this->belongsTo(Categorie::class, 'categorie_id', 'categorie_id');
    }

    public function commandes(): BelongsToMany
    {
        return $this->belongsToMany(Commande::class,'commande_vetement', 'vetement_id', 'commande_id')->using(CommandeVetement::class)->withPivot(['quantite', 'prix_unitaire', 'description']);
    }
}
