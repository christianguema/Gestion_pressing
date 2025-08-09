\documentclass{article}
\usepackage[utf8]{inputenc}
\usepackage[a4paper, margin=2cm]{geometry}
\usepackage{xcolor}
\usepackage{tabularx}
\usepackage{colortbl}
\usepackage{multirow}
\usepackage{graphicx}
\usepackage{fancyhdr}

% Définir la couleur bleue claire (#0d6efd)
\definecolor{lightblue}{HTML}{0d6efd}

% Configuration de la page
\pagestyle{fancy}
\fancyhf{}
\renewcommand{\headrulewidth}{0pt}

\begin{document}

% En-tête avec le logo et le titre
\begin{minipage}{0.5\textwidth}
\textcolor{lightblue}{\LARGE\textbf{FACTURE}}\\[0.5cm]
\textbf{N°}: @latex($commande->commande_id)-@latex($commande->created_at)\\
\end{minipage}

% Informations client et personnel
\vspace{1cm}
\begin{minipage}{0.5\textwidth}
\textbf{\color{lightblue}Client}\\
@latex($commande->client->user->name) @latex($commande->client->user->last_name)\\
Tél: @latex($commande->client->user->contact ?? '-')
\end{minipage}
\begin{minipage}{0.5\textwidth}
\textbf{\color{lightblue}Personnel}\\
Nom : @latex($commande->personnel->user->name)\\
Contact : @latex($commande->personnel->user->contact ?? '-')
\end{minipage}

\vspace{1cm}

% Tableau des articles
\setlength{\arrayrulewidth}{0.5mm}
\setlength{\tabcolsep}{18pt}
\renewcommand{\arraystretch}{1.5}

\begin{tabular}{|l|c|r|r|r|}
\hline
\rowcolor{lightblue}\color{white}\textbf{Désignation} &
\color{white}\textbf{Quantité} &
\color{white}\textbf{Description} &
\color{white}\textbf{Prix Unit.} &
\color{white}\textbf{Montant} \\
\hline

@foreach($commande->vetements as $vetement)
@latex($vetement->type) &
@latex($vetement->pivot->quantite) &
@latex($vetement->pivot->description) &
@if(str_contains(strtolower($commande->typeFacturation->libelle ?? ''), 'kilo'))
@latex(number_format($commande->prix_unitaire_kilo, 0, ',', ' ')) &
@latex(number_format($commande->prix_unitaire_kilo * $vetement->pivot->quantite, 0, ',', ' '))
@else
@latex(number_format($vetement->pivot->prix_unitaire, 0, ',', ' ')) &
@latex(number_format($vetement->pivot->prix_unitaire * $vetement->pivot->quantite, 0, ',', ' '))
@endif \\
\hline
@endforeach
\end{tabular}

\vspace{1cm}

% Résumé des montants
\begin{flushright}
\begin{tabular}{lr}
\textbf{Montant Total:} & @latex(number_format($commande->montant_total, 0, ',', ' ')) FCFA\\
@if($commande->remise_id)
\textbf{Remise:} & @latex(number_format($montant_remise, 0, ',', ' ')) FCFA\\
@endif
\hline
\textbf{\color{lightblue}Net à Payer:} & \textbf{@latex(number_format($commande->montant_total - ($montant_remise ?? 0),
0, ',', ' '))} FCFA
\end{tabular}
\end{flushright}

\vspace{2cm}

% Zone de signature
\begin{minipage}{0.45\textwidth}
\framebox[1.1\width]{
\begin{minipage}{0.9\textwidth}
\centering
\vspace{2cm}
Signature Client
\vspace{0.5cm}
\end{minipage}
}
\end{minipage}
\hfill
\begin{minipage}{0.45\textwidth}
\framebox[1.1\width]{
\begin{minipage}{0.9\textwidth}
\centering
\vspace{2cm}
Cachet et Signature
\vspace{0.5cm}
\end{minipage}
}
\end{minipage}

\vfill

% Pied de page
\begin{center}
\textit{\color{lightblue}Merci de votre confiance}\\
\textbf{@latex($commande->pressing->nom)}\\
@latex($commande->pressing->adresse)
\end{center}

\end{document}
