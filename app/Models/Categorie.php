<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Categorie extends Model
{
    use HasFactory;

    protected $fillable = [
        'intitule',
    ];

    protected $primaryKey = 'categorie_id';

    public function vetements(): HasMany
    {
        return $this->hasMany(Vetement::class, 'categorie_id', 'categorie_id');
    }
}
