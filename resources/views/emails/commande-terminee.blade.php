<!DOCTYPE html>
<html>
<body>
    <h2>Votre commande est terminée</h2>
    <p>Bonjour {{ $commande->client->user->name }},</p>
    <p>Votre commande N° {{ $commande->numero_ticket }} est terminée.</p>
    <p>Montant : {{ $commande->montant_total }} FCFA</p>
</body>
</html>
