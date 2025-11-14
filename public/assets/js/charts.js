//chart du dashboard - répartition des commandes
const ctx = document.getElementById("commandesChart");
fetch("/gestionnaire/dashboard/statistiques")
    .then((response) => response.json())
    .then((stats) => {
        new Chart(ctx, {
            type: "bar",
            data: {
                labels: ["Kilo", "Vêtement"],
                datasets: [
                    {
                        label: "Répartition des commandes",
                        data: [stats.commandes_kilo, stats.commandes_vetement],
                        backgroundColor: [
                            "rgba(13, 110, 253, 0.5)",
                            "rgba(25, 135, 84, 0.5)",
                        ],
                        borderColor: ["rgb(13, 110, 253)", "rgb(25, 135, 84)"],
                        borderWidth: 1,
                    },
                ],
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true,
                    },
                },
            },
        });
    })
    .catch((error) => {
        console.error("Erreur lors du chargement des statistiques:", error);
    });




// Charger les modes de paiement quand le modal s'ouvre
$("#payementCard").on("show.bs.modal", function () {
    const select = document.getElementById("mode_paiement");

    // Vider le select sauf la première option
    while (select.options.length > 1) {
        select.remove(1);
    }

    // Charger les modes de paiement via Fetch
    fetch("/personnel/modes-paiement")
        .then((response) => {
            if (!response.ok) {
                throw new Error("Erreur réseau");
            }
            return response.json();
        })
        .then((modes) => {
            modes.forEach((mode) => {
                //créer le text de l'option avec nom de telephone
                const optionText = mode.telephone
                    ? `${mode.nom} - ${mode.telephone}`
                    : mode.nom;

                const option = new Option(optionText, mode.mode_paiement_id);

                select.add(option);
            });
        })
        .catch((error) => {
            console.error("Erreur:", error);
            alert("Erreur lors du chargement des modes de paiement");
        });
});

//génération automatique du mot de passe pour le champ password du formulaire de création d'un personnel
document
    .getElementById("generatePassword")
    .addEventListener("click", function () {
        // Caractères pour le mot de passe
        const chars =
            "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*";
        let password = "";

        // Générer un mot de passe de 8 caractères
        for (let i = 0; i < 8; i++) {
            password += chars.charAt(Math.floor(Math.random() * chars.length));
        }

        // Remplir les deux champs
        document.getElementById("password").value = password;
        document.getElementById("password_confirmation").value = password;

        // Option: Afficher temporairement le mot de passe
        document.getElementById("password").type = "text";
        document.getElementById("password_confirmation").type = "text";

        // Recacher après 3 secondes
        setTimeout(() => {
            document.getElementById("password").type = "password";
            document.getElementById("password_confirmation").type = "password";
        }, 3000);
    });



