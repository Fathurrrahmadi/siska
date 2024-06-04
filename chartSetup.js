$(document).ready(function() {
    // Setup for Pie Chart and Bar Chart
    $.ajax({
        url: 'connection/crud_pg.php',
        method: 'GET',
        data: { action: 'get_chart_data' },
        dataType: 'json',
        success: function(response) {
            if (response.success) {
                // Setup Pie Chart
                var pieLabels = [];
                var pieCounts = [];

                response.pie.forEach(function(item) {
                    pieLabels.push(item.sumber_gangguan);
                    pieCounts.push(item.jumlah);
                });

                var pieCtx = document.getElementById('myChartpie').getContext('2d');
                var myChartpie = new Chart(pieCtx, {
                    type: 'pie',
                    data: {
                        labels: pieLabels,
                        datasets: [{
                            label: 'Jumlah Pelanggaran',
                            data: pieCounts,
                            backgroundColor: [
                                'rgba(255, 99, 132, 0.2)',
                                'rgba(54, 162, 235, 0.2)',
                                'rgba(255, 206, 86, 0.2)',
                                'rgba(75, 192, 192, 0.2)',
                                'rgba(153, 102, 255, 0.2)',
                                'rgba(255, 159, 64, 0.2)'
                            ],
                            borderColor: [
                                'rgba(255, 99, 132, 1)',
                                'rgba(54, 162, 235, 1)',
                                'rgba(255, 206, 86, 1)',
                                'rgba(75, 192, 192, 1)',
                                'rgba(153, 102, 255, 1)',
                                'rgba(255, 159, 64, 1)'
                            ],
                            borderWidth: 1
                        }]
                    },
                    options: {
                        responsive: true,
                        plugins: {
                            legend: {
                                position: 'top',
                            },
                            tooltip: {
                                callbacks: {
                                    label: function(tooltipItem) {
                                        return 'Jumlah Pelanggaran: ' + tooltipItem.raw;
                                    }
                                }
                            }
                        }
                    }
                });

                // Setup Bar Chart
                var barLabels = [];
                var barCounts = [];

                response.bar.forEach(function(item) {
                    barLabels.push(item.pihak_pelapor);
                    barCounts.push(item.jumlah);
                });

                var barCtx = document.getElementById('myChartbar').getContext('2d');
                var myChartbar = new Chart(barCtx, {
                    type: 'bar',
                    data: {
                        labels: barLabels,
                        datasets: [{
                            label: 'Jumlah Pelaporan',
                            data: barCounts,
                            backgroundColor: 'rgba(54, 162, 235, 0.2)',
                            borderColor: 'rgba(54, 162, 235, 1)',
                            borderWidth: 1
                        }]
                    },
                    options: {
                        scales: {
                            y: {
                                beginAtZero: true
                            }
                        }
                    }
                });
            } else {
                console.error('Error fetching data:', response.message);
                alert('Error fetching data: ' + response.message);
            }
        },
        error: function(xhr, status, error) {
            console.error('Error fetching data:', status, error);
            alert('Error fetching data: ' + error);
        }
    });
});
