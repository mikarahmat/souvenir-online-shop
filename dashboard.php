<?php
// Start a session
session_start();

// Check if the user is logged in and is an admin
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header('Location: login.php');
    exit;
}

// Personalized message
$full_name = $_SESSION['full_name'];
$username = $_SESSION['username'];
$role = $_SESSION['role'];
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <!-- Custom CSS -->
    <style>
        .dashboard-container {
            margin-top: 50px;
            padding: 20px;
            background-color: #f8f9fa;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .dashboard-title {
            text-align: center;
            margin-bottom: 20px;
        }

        .card h3 {
            margin: 10px 0;
        }

        .charts-container {
            margin-top: 20px;
        }
    </style>
</head>

<body>
    <div class="container dashboard-container">
        <h2 class="dashboard-title">Admin Dashboard</h2>
        <div class="row">
            <div class="col-md-6">
                <canvas id="stockChart"></canvas>
            </div>
            <div class="col-md-6">
                <div class="card text-center">
                    <div class="card-body">
                        <h3>Total Revenue</h3>
                        <h4 id="totalRevenue">Rp 0,00</h4>
                    </div>
                </div>
            </div>
        </div>
        <div class="row charts-container">
            <div class="col-md-6">
                <canvas id="dailyRevenueChart"></canvas>
            </div>
            <div class="col-md-6">
                <canvas id="bestSellingChart"></canvas>
            </div>
        </div>
    </div>

    <!-- Dashboard JavaScript -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            fetch('get_dashboard_data.php')
                .then(response => response.json())
                .then(data => {
                    // Total Revenue
                    document.getElementById('totalRevenue').textContent = `Rp ${data.total_revenue}`;

                    // Product Stock Chart
                    const productStocks = data.product_stocks.map(item => item.product_name);
                    const stockCounts = data.product_stocks.map(item => item.stock);

                    new Chart(document.getElementById('stockChart'), {
                        type: 'bar',
                        data: {
                            labels: productStocks,
                            datasets: [{
                                label: 'Stock Count',
                                data: stockCounts,
                                backgroundColor: 'rgba(0, 123, 255, 0.5)',
                                borderColor: 'rgba(0, 123, 255, 1)',
                                borderWidth: 1
                            }]
                        },
                        options: {
                            responsive: true,
                            scales: {
                                y: {
                                    beginAtZero: true
                                }
                            }
                        }
                    });

                    // Daily Revenue Chart
                    const days = data.daily_revenues.map(item => item.day);
                    const revenues = data.daily_revenues.map(item => item.daily_revenue);

                    new Chart(document.getElementById('dailyRevenueChart'), {
                        type: 'line',
                        data: {
                            labels: days,
                            datasets: [{
                                label: 'Daily Revenue',
                                data: revenues,
                                backgroundColor: 'rgba(255, 99, 132, 0.5)',
                                borderColor: 'rgba(255, 99, 132, 1)',
                                borderWidth: 1
                            }]
                        },
                        options: {
                            responsive: true,
                            scales: {
                                y: {
                                    beginAtZero: true
                                }
                            }
                        }
                    });

                    // Best-Selling Products Chart
                    const bestSellingProducts = data.best_selling.map(item => item.product_name);
                    const totalSoldCounts = data.best_selling.map(item => item.total_sold);

                    new Chart(document.getElementById('bestSellingChart'), {
                        type: 'pie',
                        data: {
                            labels: bestSellingProducts,
                            datasets: [{
                                label: 'Total Sold',
                                data: totalSoldCounts,
                                backgroundColor: [
                                    'rgba(255, 99, 132, 0.6)',
                                    'rgba(54, 162, 235, 0.6)',
                                    'rgba(255, 206, 86, 0.6)',
                                    'rgba(75, 192, 192, 0.6)',
                                    'rgba(153, 102, 255, 0.6)',
                                    'rgba(255, 159, 64, 0.6)',
                                    'rgba(201, 203, 207, 0.6)',
                                    'rgba(255, 87, 34, 0.6)'
                                ],
                                borderWidth: 1
                            }]
                        },
                        options: {
                            responsive: true,
                            plugins: {
                                legend: {
                                    position: 'top'
                                },
                                tooltip: {
                                    callbacks: {
                                        label: function(tooltipItem) {
                                            return `${tooltipItem.label}: ${tooltipItem.raw}`;
                                        }
                                    }
                                }
                            }
                        }
                    });
                })
                .catch(error => console.error('Error fetching dashboard data:', error));
        });
    </script>
</body>

</html>