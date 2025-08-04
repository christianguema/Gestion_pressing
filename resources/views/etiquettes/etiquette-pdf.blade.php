\documentclass{article}
\begin{document}
\section*{Etiquette Commande}
Commande N°: @latex($commande_id)\\
Client: @latex($client_nom)\\
Date réception: @latex($date_reception)\\
Etat: @latex($etat)\\
\begin{itemize}
@foreach($vetements as $vetement)
    \item @latex($vetement->type) (@latex($vetement->pivot->quantite)) - @latex($vetement->pivot->description)
@endforeach
\end{itemize}
\end{document}
