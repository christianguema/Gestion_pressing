<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Commande extends Model
{
    use HasFactory;

    // Si tu as changé le nom de la table par défaut
    protected $table = 'commandes';

    // Définir les champs remplissables
    protected $fillable = [
        'client_id',
        'personnel_id',
        'type_prestation_id',
        'type_facturation_id',
        'pressing_id',
        'date_reception',
        'date_livraison',
        'etat',
        'montant_total',
    ];

    protected $primaryKey = 'commande_id';

    protected $dates = ['date_reception', 'date_livraison'];

    // Relations

    /**
     * Une commande appartient à un client
     */
    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class, 'client_id', 'client_id');
    }

    /**
     * Une commande appartient à un personnel
     */
    public function personnel(): BelongsTo
    {
        return $this->belongsTo(Personnel::class, 'personnel_id', 'personnel_id');
    }

    /**
     * Une commande a un type de prestation
     */
    public function typePrestation(): BelongsTo
    {
        return $this->belongsTo(TypePrestation::class, 'type_prestation_id', 'type_prestation_id');
    }

    /**
     * Une commande a un type de facturation
     */
    public function typeFacturation(): BelongsTo
    {
        return $this->belongsTo(TypeFacturation::class, 'type_facturation_id', 'type_facturation_id');
    }

    /**
     * Une commande appartient à un pressing
     */
    public function pressing(): BelongsTo
    {
        return $this->belongsTo(Pressing::class, 'pressing_id', 'pressing_id');
    }

    /**
     * Une commande peut avoir plusieurs vêtements via la table pivot commande_vetement
     */
    public function vetements(): BelongsToMany
    {
        return $this->belongsToMany(Vetement::class, 'commande_vetement', 'commande_id', 'vetement_id')
                    ->using(CommandeVetement::class)
                    ->withPivot(['quantite', 'poids']);
    }

    /**
     * Une commande peut avoir un paiement (si décommenté dans la migration)
     */
    public function paiement(): HasOne
    {
        return $this->hasOne(Paiement::class, 'commande_id', 'commande_id');
    }
}