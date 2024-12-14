<?php
include '../service/database-admin.php';

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Retrieve status data
$status_query = "SELECT status, COUNT(*) as count FROM pendaftaran GROUP BY status";
$status_result = $conn->query($status_query);

// Retrieve monthly data
$monthly_query = "SELECT MONTH(waktu) as month, COUNT(*) as count FROM pendaftaran GROUP BY MONTH(waktu)";
$monthly_result = $conn->query($monthly_query);

$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Statistik Pendaftar</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        .container {
            max-width: 1200px;
            margin: 0 auto;
            display: flex;
            flex-direction: column;
            flex-wrap: wrap;
            gap: 20px;
            padding: 20px;
        }
        .dashboard-title {
            width: 100%;
            text-align: center;
            color: #333;
            margin-bottom: 20px;
        }
        .chart-card {
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
            padding: 20px;
            flex: 1;
            min-width: 300px;
        }
        .chart-container {
            width: 100%;
            height: 300px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1 class="dashboard-title">Statistik Pendaftar</h1>
        
        <div class="chart-card">
            <h2 class="chart-title">Status Pendaftar</h2>
            <p class="chart-subtitle">Menampilkan Status Para Pendaftar</p>
            <div class="chart-container">
                <canvas id="statusChart"></canvas>
            </div>
        </div>
        
        <div class="chart-card">
            <h2 class="chart-title">Pendaftaran Bulanan</h2>
            <p class="chart-subtitle">Menampilkan Pendaftaran Bulanan</p>
            <div class="chart-container">
                <canvas id="monthlyChart"></canvas>
            </div>
        </div>
    </div>

    <script>
        // Status Pendaftar Donut Chart
        new Chart(document.getElementById('statusChart'), {
            type: 'doughnut',
            data: {
                labels: [<?php while ($row = $status_result->fetch_assoc()) { echo "'" . $row['status'] . "', "; } ?>],
                datasets: [{
                    data: [<?php $status_result->data_seek(0); while ($row = $status_result->fetch_assoc()) { echo $row['count'] . ", "; } ?>],
                    backgroundColor: [
                        '#FF6384', 
                        '#36A2EB', 
                        '#FFCE56', 
                        '#4BC0C0'
                    ]
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    title: {
                        display: true,
                        text: 'Distribusi Status Pendaftar'
                    }
                }
            }
        });

        // Pendaftaran Bulanan Bar Chart
        new Chart(document.getElementById('monthlyChart'), {
            type: 'bar',
            data: {
                labels: [<?php while ($row = $monthly_result->fetch_assoc()) { echo "'" . date('M', mktime(0, 0, 0, $row['month'], 1)) . "', "; } ?>],
                datasets: [{
                    label: 'Jumlah Pendaftar',
                    data: [<?php $monthly_result->data_seek(0); while ($row = $monthly_result->fetch_assoc()) { echo $row['count'] . ", "; } ?>],
                    backgroundColor: '#36A2EB'
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    title: {
                        display: true,
                        text: 'Pendaftaran Bulanan'
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>
</body>
</html>