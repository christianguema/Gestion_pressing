<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ModePaiement extends Model
{
    protected $fillable = ["logo","nom","telephone"];

    protected $table = "mode_paiements";

    protected $primaryKey = "mode_paiement_id";

    public function paiement() : HasMany
    {
        return $this->hasMany(Paiement::class, "paiement_id");
    }


}
