<!DOCTYPE html>
<html lang="en">

<head>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>

<body>
    <h2>Statistik Penerimaan | <?= htmlspecialchars($_SESSION['nama_sekolah'])?></h2>
    <table>
        <thead>
            <tr>
                <th>Total pendaftar</th>
                <th>Pendaftar lolos</th>
                <th>Pendaftar gagal</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td><?= htmlspecialchars($analisaSekolah['total_pendaftar']); ?> Orang</td>
                <td><?= htmlspecialchars($analisaSekolah['pendaftar_diterima']); ?> Orang</td>
                <td><?= htmlspecialchars($analisaSekolah['pendaftar_ditolak']); ?> Orang</td>
            </tr>
        </tbody>
    </table>

    <div style="width: 60em; margin-top: 20px;">
        <canvas id="pendaftarChart"></canvas>
    </div>

    <!-- Script untuk membuat grafik -->
    <script>
        const totalPendaftar = <?= json_encode($analisaSekolah['total_pendaftar'] ?? 0); ?>;
        const pendaftarDiterima = <?= json_encode($analisaSekolah['pendaftar_diterima'] ?? 0); ?>;
        const pendaftarDitolak = <?= json_encode($analisaSekolah['pendaftar_ditolak'] ?? 0); ?>;


        const ctx = document.getElementById('pendaftarChart').getContext('2d');
        const pendaftarChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ['Total Pendaftar', 'Pendaftar Lolos', 'Pendaftar Gagal'],
                datasets: [{
                    label: 'Jumlah Pendaftar',
                    data: [totalPendaftar, pendaftarDiterima, pendaftarDitolak],
                    backgroundColor: [
                        'rgba(54, 162, 235, 0.6)',
                        'rgba(75, 192, 192, 0.6)',
                        'rgba(255, 99, 132, 0.6)'
                    ],
                    borderColor: [
                        'rgba(54, 162, 235, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(255, 99, 132, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'Jumlah (Orang)'
                        }
                    },
                    x: {
                        title: {
                            display: true,
                            text: 'Kategori'
                        }
                    }
                },
                plugins: {
                    legend: {
                        display: true,
                        position: 'top'
                    },
                    title: {
                        display: true,
                        text: 'Statistik Pendaftar SMK 10 Kabupaten Bandung'
                    }
                }
            }
        });
    </script>
</body>

</html>