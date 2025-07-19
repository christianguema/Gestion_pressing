<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Notification extends Model
{
    use HasFactory;

    protected $fillable = [
        'notification_id',
        'contenu',
        'lu',
        'date_envoi',
    ];

    protected $primaryKey = 'notification_id';

    // public function user(): BelongsTo
    // {
    //     return $this->belongsTo(User::class);
    // }
}