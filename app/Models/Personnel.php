<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Personnel extends Model
{
    use HasFactory;

    protected $fillable = [
        'personnel_id',
        'pressing_id',
        'poste',
        'date_embauche',
    ];

    protected $primaryKey = 'personnel_id';

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'personnel_id', 'id');
    }

    public function commandes(): HasMany
    {
        return $this->hasMany(Commande::class);
    }

    public function pressing(): BelongsTo
    {
        return $this->belongsTo(Pressing::class, 'pressing_id', 'pressing_id');
    }
}
