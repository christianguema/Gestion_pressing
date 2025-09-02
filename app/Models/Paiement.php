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
        'date_paiement',
        'mode_paiement_id',
        'reference_transaction',
    ];

    protected $primaryKey = 'paiement_id';

    public function commande(): BelongsTo
    {
        return $this->belongsTo(Commande::class);
    }

    public function mode_paiement(): BelongsTo
    {
        return $this->belongsTo(ModePaiement::class,"mode_paiement_id");
    }
}
