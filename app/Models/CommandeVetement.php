<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\Pivot;

class CommandeVetement extends Pivot
{
    use HasFactory;

    protected $fillable = [
        'description',
        'prix_unitaire',
        'quantite',
    ];

    protected $primaryKey = ['commande_id','vetement_id'];


}
