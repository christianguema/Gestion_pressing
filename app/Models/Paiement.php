<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Paiement extends Model
{
    use HasFactory;

    protected $fillable = [
        'commande_id',
        'montant',
        'mode_paiement',
        'date_paiement',
        'reference_transaction',
    ];

    protected $primaryKey = 'paiement_id';

    public function commande(): BelongsTo
    {
        return $this->belongsTo(Commande::class);
    }
}
