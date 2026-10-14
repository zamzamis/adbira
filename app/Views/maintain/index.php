<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>
<div class="container my-5">
    <h2 class="mb-4 text-center">📊 Maintain Surat</h2>

    <?php if (session()->getFlashdata('success')) : ?>
        <div class="alert alert-success">
            <?= session()->getFlashdata('success') ?>
        </div>
    <?php endif; ?>

    <?php if (session()->getFlashdata('error')) : ?>
        <div class="alert alert-danger">
            <?= session()->getFlashdata('error') ?>
        </div>
    <?php endif; ?>

    <!-- Total Surat -->
    <div class="text-center mb-4">
        <h5 class="fw-bold">Jumlah Surat Masuk Tahun <?= date('Y') ?>: <?= array_sum($chartData) ?> Surat</h5>
        <p class="text-muted mb-0">Total Ukuran File: <?= getFolderSize(ROOTPATH . 'public/file') ?> MB</p>
    </div>

    <!-- Grafik -->
    <div class="card shadow mb-5">
        <div class="card-header bg-primary text-white">
            Statistik Surat Masuk <?= date('Y') ?>
        </div>
        <div class="card-body p-0">
            <div class="chart-container" style="position: relative; height: 400px; padding: 15px;">
                <canvas id="suratChart"></canvas>
            </div>
        </div>
    </div>

    <!-- Tombol Aksi -->
    <div class="row">
        <!-- Rekap PDF -->
        <div class="col-md-6 mb-3">
            <div class="card shadow h-100">
                <div class="card-body text-center d-flex flex-column justify-content-center">
                    <h5 class="card-title">Rekap Database</h5>
                    <p class="card-text">Ekspor semua data surat ke file PDF</p>
                    <a href="<?= base_url('maintain/exportSuratToPdf') ?>" class="btn btn-warning">
                        🧾 Rekap Surat ke PDF
                    </a>
                </div>
            </div>
        </div>

        <!-- ZIP File -->
        <div class="col-md-6 mb-3">
            <div class="card shadow h-100">
                <div class="card-body text-center d-flex flex-column justify-content-center">
                    <h5 class="card-title">Arsip PDF Surat</h5>
                    <p class="card-text">Kompres semua PDF surat dalam 1 file ZIP</p>
                    <a href="<?= base_url('maintain/zipSurat') ?>" class="btn btn-success">
                        📦 Download ZIP Surat
                    </a>
                </div>
            </div>
        </div>

        <!-- Hapus Data -->
        <div class="col-md-12 mb-3">
            <div class="card shadow">
                <div class="card-body text-center">
                    <h5 class="card-title text-danger">Hapus Isi Tabel</h5>
                    <p class="card-text">Menghapus seluruh data surat dari sistem</p>
                    <form action="<?= site_url('maintain/clearSurat') ?>" method="post">
                        <?= csrf_field() ?>
                        <button type="submit" class="btn btn-danger"
                            onclick="return confirm('Yakin ingin menghapus SEMUA data surat dan file?')">
                            <i class="fas fa-trash"></i> Hapus Semua Data
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const ctx = document.getElementById('suratChart').getContext('2d');
        const chart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Ags', 'Sep', 'Okt', 'Nov', 'Des'],
                datasets: [{
                    label: 'Jumlah Surat',
                    data: <?= json_encode($chartData) ?>,
                    backgroundColor: 'rgba(54, 162, 235, 0.7)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                layout: {
                    padding: {
                        top: 20,
                        right: 20,
                        bottom: 20,
                        left: 20
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            precision: 0,
                            stepSize: 1
                        }
                    },
                    x: {
                        ticks: {
                            autoSkip: false,
                            maxRotation: 45,
                            minRotation: 45
                        }
                    }
                },
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        enabled: true,
                        mode: 'index',
                        intersect: false
                    }
                }
            }
        });

        // Responsive adjustment for mobile
        function handleResize() {
            if (window.innerWidth < 768) {
                chart.options.scales.x.ticks.maxRotation = 90;
                chart.options.scales.x.ticks.minRotation = 90;
                chart.options.layout.padding.left = 10;
                chart.options.layout.padding.right = 10;
            } else {
                chart.options.scales.x.ticks.maxRotation = 45;
                chart.options.scales.x.ticks.minRotation = 45;
                chart.options.layout.padding.left = 20;
                chart.options.layout.padding.right = 20;
            }
            chart.update();
        }

        window.addEventListener('resize', handleResize);
        handleResize(); // Initial call
    });
</script>

<?= $this->endSection(); ?>