<div class="shadow-lg rounded-lg overflow-hidden bg-white">
    <div class="flex justify-between items-center border-b p-3 bg-primary">
        <h2 class="text-xl">Monthly Expenses by Category for {{ now()->format('Y') }}</h2>
        <i class="fa-solid fa-chart-simple fa-xl"></i>
    </div>
    <div>
        <div class="p-2">
            <canvas id="expensesChart"></canvas>
        </div>

        <script>
            const labels = [
                'January', 'February', 'March', 'April', 'May', 'June',
                'July', 'August', 'September', 'October', 'November', 'December'
            ];

            const expenses = @json((array_values($monthlyExpensesByCategories)));
            let dataset = []

            expenses.forEach( (element) => {
                dataset.push(
                    {
                        label: element.title,
                        data: Object.values(element.months),
                        backgroundColor: element.color,
                        borderRadius: 4,
                        barPercentage: 0.75
                    }
                )
            })

            const chart = new Chart(document.getElementById('expensesChart').getContext('2d'), {
                type: 'bar',
                data: {
                    labels: labels,
                    datasets: dataset
                },
                options: {
                    responsive: true,
                    scales: {
                        x: {
                            stacked: true,
                            grid: { display: false }
                        },
                        y: {
                            stacked: true,
                            beginAtZero: true,
                            grid: { display: false }
                        }
                    },
                    plugins: {
                        legend: {
                            display: true,
                            position: 'top',
                            labels: {
                                padding: 20,
                                boxWidth: 20,
                                usePointStyle: true
                            }
                        }
                    }
                }
            });
        </script>
    </div>
</div>
