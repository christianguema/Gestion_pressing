<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Client extends Model
{
    use HasFactory;

    protected $fillable = [
        'client_id',
        'genre',
    ];

    protected $primaryKey = 'client_id';

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class,"client_id","id");
    }

    public function commandes(): HasMany
    {
        return $this->hasMany(Commande::class,"client_id","client_id");
    }
};
