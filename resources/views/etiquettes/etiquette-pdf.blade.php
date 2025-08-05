\documentclass{article}
\usepackage[utf8]{inputenc}
\usepackage{geometry}
\usepackage{tikz}
\geometry{paperwidth=11cm, paperheight=12cm, margin=0.7cm}
\pagestyle{empty}
\begin{document}

\begin{center}
\begin{tikzpicture}
\node[draw=blue, dashed, thick, rounded corners=8pt, inner sep=10pt, minimum width=10cm, minimum height=11cm] (box) {
\begin{minipage}{6.5cm}
\begin{center}

\section*{Etiquette Commande}
Commande N°: @latex($commande_id)\\
Client: @latex($client_nom)\\
Contact: @latex($client_contact)\\
Date livraison: @latex($date_livraison)\\
Date réception: @latex($date_reception)\\
Etat: @latex($etat)\\
\begin{itemize}
@foreach($vetements as $vetement)
    \item @latex($vetement->type) (@latex($vetement->pivot->quantite)) - @latex($vetement->pivot->description)
@endforeach
\end{itemize}

\end{center}
\end{minipage}
};

\end{tikzpicture}
\end{center}

\end{document}
