<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RapportsPerformance extends Model
{
    use HasFactory;

    protected $fillable = [
        'pressing_id',
        'periode',
        'revenus',
        'nombre_commande',
    ];

    public $timestamps = true;
    protected $primaryKey = 'rapports_performance_id';

    protected $casts = [
        'periode' => 'datetime',
        'revenus' => 'integer',
        'nombre_commande' => 'integer',
    ];




    public function pressing(): BelongsTo
    {
        return $this->belongsTo(Pressing::class, 'pressing_id', 'pressing_id');
    }

}
