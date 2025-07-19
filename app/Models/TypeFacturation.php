<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TypeFacturation extends Model
{
    use HasFactory;

    protected $fillable = [
        'libelle',
    ];

    protected $primaryKey = 'type_facturation_id';

    public function commandes(): HasMany
    {
        return $this->hasMany(Commande::class);
    }
}