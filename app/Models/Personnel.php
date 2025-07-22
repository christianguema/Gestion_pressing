<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Permission\Traits\HasRoles;

class Personnel extends Model
{
    use HasFactory;

    protected $fillable = [
        'profilImage',
        'poste',
        'date_embauche',
        'user_id',
        'pressing_id',
        
    ];

    protected $primaryKey = 'personnel_id';

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function commandes(): HasMany
    {
        return $this->hasMany(Commande::class,'personnel_id');
    }

    public function pressing(): BelongsTo
    {
        return $this->belongsTo(Pressing::class, 'pressing_id');
    }
}