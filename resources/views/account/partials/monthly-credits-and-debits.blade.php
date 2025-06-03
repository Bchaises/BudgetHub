<div class="shadow-lg">
    <div class="flex justify-between items-center border-b p-3 rounded-t-lg bg-primary">
        <h1 class="text-xl">Monthly Credits and Debits for {{ now()->format('Y') }}</h1>
        <i class="fa-solid fa-chart-simple fa-xl"></i>
    </div>

    <div class="p-2 rounded-b-lg overflow-hidden bg-white">
        <canvas id="myChart2"></canvas>
    </div>
</div>

<script>
    const ctx2 = document.getElementById('myChart2');
    const months2 = [
        'Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin',
        'Juillet', 'Août', 'Septembre', 'Octobre', 'Novembre', 'Décembre'
    ];
    const credits = @json($monthlyExpenses['monthlyCredits']);
    const debits = @json($monthlyExpenses['monthlyDebits']);
    new Chart(ctx2, {
        type: 'bar',
        data: {
            labels: months2,
            datasets: [
                {
                    label: 'Crédits',
                    data: credits,
                    backgroundColor: 'rgba( 236, 112, 99, 1)',
                    borderRadius: 4,
                    barPercentage: 0.75
                },
                {
                    label: 'Débits',
                    data: debits,
                    backgroundColor: 'rgba( 93, 173, 226 , 1)',
                    borderRadius: 4,
                    barPercentage: 0.75
                }
            ]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true,
                    grid: {
                        display: false
                    }
                },
                x: {
                    grid: {
                        display: false
                    }
                }
            }
        }
    });
</script>
