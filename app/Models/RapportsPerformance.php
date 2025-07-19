<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RapportsPerformance extends Model
{
    use HasFactory;

    protected $fillable = [
        'gestionnaire_id',
        'periode',
        'revenus',
        'nombre_commande',
        // 'satisfaction_client',
    ];

    protected $primaryKey = 'rapports_performance_id';

    public function gestionnaire(): BelongsTo
    {
        return $this->belongsTo(Gestionnaire::class);
    }


    public function pressing(): BelongsTo
    {
        return $this->belongsTo(Pressing::class);
    }

}