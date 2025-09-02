\documentclass{article}
\usepackage[utf8]{inputenc}
\usepackage{geometry}
\usepackage{tikz}
\usepackage{qrcode}
\usepackage{fontawesome5}
\usepackage{xcolor}
\usepackage{enumitem}

% Définir les couleurs
\definecolor{primary}{HTML}{0d6efd}
\definecolor{secondary}{HTML}{6c757d}
\definecolor{light}{HTML}{f8f9fa}

\geometry{paperwidth=15cm, paperheight=18cm, margin=1cm}
\pagestyle{empty}

\begin{document}

\begin{center}
\begin{tikzpicture}

% Fond du ticket avec bordure arrondie
\node[fill=light, draw=primary, thick, rounded corners=8pt, inner sep=15pt, minimum width=9cm, minimum height=3cm] (box) {
    \begin{minipage}{10cm}
    \begin{center}
        % En-tête du ticket
        {\color{primary}\Huge\textbf{PRESSING}}\\[0.4cm]
        {\color{secondary}\large Service de qualité}\\[0.5cm]

        % Ligne de séparation décorative
        \tikz\draw[primary, thick] (0,0) -- (8,0);\\[0.5cm]

        % Informations principales
        {\Large\textbf{Ticket N°:}} {\color{primary}\Large\textbf{@latex($numero_ticket)}}\\[0.4cm]

        % Informations client avec icônes FontAwesome simplifiées
        \begin{tabular}{@{}l@{}}
        {\large\faUser\ \textbf{Client:} @latex($client_nom)}\\[0.2cm]
        {\large\faPhone\ \textbf{Tél:} @latex($client_contact)}\\[0.2cm]
        {\large\faCalendar\ \textbf{Réception:} @latex(date('d/m/Y', strtotime($date_reception)))}\\[0.2cm]
        {\large\faClock\ \textbf{Livraison:} @latex(date('d/m/Y', strtotime($date_livraison)))}\\[0.2cm]
        {\large\faTag\ \textbf{État:} {\color{primary}@latex($etat)}}
        \end{tabular}\\[0.5cm]

        % Liste des articles
        \begin{tikzpicture}
        \node[draw=primary, rounded corners=4pt, inner sep=12pt] {
            \begin{minipage}{8.5cm}
            {\large\textbf{Articles:}}\\[0.2cm]
            \begin{itemize}[leftmargin=*]
            @foreach($vetements as $vetement)
                \item {\large @latex($vetement->type) (\textbf{@latex($vetement->pivot->quantite)})}
                      {\color{secondary} @latex($vetement->pivot->description)}
            @endforeach
            \end{itemize}
            \end{minipage}
        };
        \end{tikzpicture}\\[0.5cm]

        % QR Code avec le numéro de ticket
        \qrcode[height=3cm]{@latex($numero_ticket)}\\[0.3cm]
        {\color{secondary}Scannez pour suivre votre commande}

    \end{center}
    \end{minipage}
};

\end{tikzpicture}
\end{center}

\end{document}
