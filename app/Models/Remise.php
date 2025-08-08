<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Remise extends Model
{
    protected $table = 'remises';

    protected $fillable = [
        'type_remise',
        'valeur',
        'description',
    ];

    protected $primaryKey = 'remise_id';

    /**
     * Une remise appartient à une commande
     */
    public function commande(): HasOne
    {
        return $this->HasOne(Commande::class, 'remise_id', 'remise_id');
    }
}
