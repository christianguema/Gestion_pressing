\documentclass{article}
\usepackage[utf8]{inputenc}
\usepackage[T1]{fontenc}
\usepackage{dejavu}
\usepackage[a4paper, margin=2cm]{geometry}
\usepackage{xcolor}
\usepackage{tabularx}
\usepackage{colortbl}
\usepackage{multirow}
\usepackage{graphicx}
\usepackage{fancyhdr}
\usepackage{tikz}
\usepackage{eso-pic}

% Définir la couleur bleue claire (#0d6efd)
\definecolor{lightblue}{HTML}{0d6efd}

% Filigrane avec tikz
\AddToShipoutPictureBG{%
\begin{tikzpicture}[overlay, remember picture]
\node[rotate=45, scale=12, text=lightgray!30, inner sep=0pt]
at (current page.center) {\textbf{\Large @latex($nom_pressing)}};
\end{tikzpicture}
}

% Configuration de la page
\pagestyle{fancy}
\fancyhf{}
\renewcommand{\headrulewidth}{0pt}
\renewcommand{\familydefault}{\sfdefault}

\begin{document}

% En-tête
\begin{minipage}{0.6\textwidth}
\textcolor{lightblue}{\LARGE\textbf{FACTURE}}\\[0.2cm]
\textbf{N° Facture} : \texttt{@latex($num_facture)}\\[0.2cm]
\textbf{Date de paiement} : @latex($date_paiement)
\end{minipage}

\vspace{1cm}

% Informations client et personnel
\begin{minipage}{0.5\textwidth}
\textbf{\color{lightblue}Client}\\
@latex($commande->client->user->name . ' ' . ($commande->client->user->lastname ?? '')) \\
Tél : @latex($commande->client->user->contact ?? 'Non spécifié')
\end{minipage}
\begin{minipage}{0.5\textwidth}
\textbf{\color{lightblue}Personnel}\\
@latex($commande->personnel->user->name ?? 'Non spécifié') \\
Contact : @latex($commande->personnel->user->contact ?? 'Non spécifié')
\end{minipage}

\vspace{1cm}

% Tableau dynamique selon le mode de facturation
\setlength{\arrayrulewidth}{0.5mm}
\setlength{\tabcolsep}{6pt}
\renewcommand{\arraystretch}{1.6}

@if(str_contains(strtolower($commande->typeFacturation->libelle ?? ''), 'kilo'))
% Mode facturation par kilo
\begin{tabularx}{\textwidth}{|>{\raggedright\arraybackslash}X|c|>{\raggedright\arraybackslash}p{4cm}|l|}
\hline
\rowcolor{lightblue}\color{white}\textbf{Désignation} &
\color{white}\textbf{Quantité} &
\color{white}\textbf{Description} \\
\hline
@foreach($commande->vetements as $vetement)
@latex($vetement->type) &
@latex(number_format($vetement->pivot->quantite)) &
@latex($vetement->pivot->description ?? 'Non spécifiée') \\
\hline
@endforeach
\end{tabularx}

\vspace{1cm}

\begin{flushright}
\begin{tabular}{lr}
\textbf{Prix au kg :} & @latex(number_format($commande->prix_unitaire_kilo, 0, ',', ' ')) FCFA \\
\textbf{Poids total :} & @latex(number_format($commande->poids_total, 2, ',', ' ')) kg \\
\hline
\textbf{Montant Total :} & @latex(number_format($commande->prix_unitaire_kilo * $commande->poids_total, 0, ',', ' '))
FCFA \\
@if($montant_remise > 0)
\textbf{Remise :} & @latex(number_format($montant_remise, 0, ',', ' ')) FCFA \\
@endif
\hline
\textbf{\color{lightblue}Net à Payer :} & \textbf{@latex(number_format(($commande->prix_unitaire_kilo *
$commande->poids_total) - $montant_remise, 0, ',', ' ')) FCFA}
\end{tabular}
\end{flushright}

@else
% Mode facturation par vetements
\begin{tabularx}{\textwidth}{|>{\raggedright\arraybackslash}X|c|>{\raggedright\arraybackslash}p{4cm}|r|r|}
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
@latex($vetement->pivot->description ?? 'Non spécifiée') &
@latex(number_format($vetement->pivot->prix_unitaire, 0, ',', ' ')) &
@latex(number_format($vetement->pivot->prix_unitaire * $vetement->pivot->quantite, 0, ',', ' ')) \\
\hline
@endforeach
\end{tabularx}

\vspace{1cm}

\begin{flushright}
\begin{tabular}{lr}
\textbf{Montant Total :} & @latex(number_format($commande->montant_total, 0, ',', ' ')) FCFA \\
@if($montant_remise > 0)
\textbf{Remise :} & @latex(number_format($montant_remise, 0, ',', ' ')) FCFA \\
@endif
\hline
\textbf{\color{lightblue}Net à Payer :} & \textbf{@latex(number_format($commande->montant_total - $montant_remise, 0,
',', ' ')) FCFA}
\end{tabular}
\end{flushright}

@endif

\vspace{2cm}

% Zones de signature
\begin{minipage}{0.45\textwidth}
\framebox[1.1\width]{\begin{minipage}{0.9\textwidth}\centering\vspace{2cm}\textbf{Signature
Client}\vspace{0.5cm}\end{minipage}}
\end{minipage}
\hfill
\begin{minipage}{0.45\textwidth}
\framebox[1.1\width]{\begin{minipage}{0.9\textwidth}\centering\vspace{2cm}\textbf{Cachet et
Signature}\vspace{0.5cm}\end{minipage}}
\end{minipage}

\vfill

% Pied de page
\begin{center}
\textit{\color{lightblue}Merci de votre confiance} \\
\textbf{@latex($nom_pressing)} \\
@latex($commande->pressing->adresse)
\end{center}

\end{document}
