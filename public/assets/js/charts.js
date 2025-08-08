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
