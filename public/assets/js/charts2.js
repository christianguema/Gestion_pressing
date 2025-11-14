//chart du dashboard - performance des revenus
const ctx_revenus = document.getElementById('rapportChart').getContext('2d');
    new Chart(ctx_revenus, {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [
                {
                    label: 'Revenus (FCFA)',
                    data: revenus,
                    backgroundColor: 'rgba(54, 162, 235, 0.5)'
                },
                {
                    label: 'Nombre de Commandes',
                    data: commandes,
                    backgroundColor: 'rgba(255, 99, 132, 0.5)'
                }
            ]
        }
    });
