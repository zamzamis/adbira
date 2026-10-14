<?= $this->extend('layout/template'); ?>
<?= $this->section('content'); ?>

<div class="container mt-4">
    <div class="card shadow-sm border-0">
        <div class="card-body p-4">
            <!-- Header Section -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h3 class="card-title mb-1 text-primary fw-bold">
                        <i class="fas fa-envelope-open-text me-2"></i>Rekap Surat 
                    </h3>
                    <p class="text-muted mb-0">Manajemen dan pencarian surat</p>
                </div>
                <?php if ($filterAktif): ?>
                    <div class="badge bg-primary bg-opacity-10 text-primary p-2">
                        <i class="fas fa-filter me-1"></i> Filter Aktif
                    </div>
                <?php endif; ?>
            </div>

            <!-- Filter Tabs -->
            <ul class="nav nav-tabs mb-4" id="filterTab" role="tablist">
                <li class="nav-item" role="presentation">
                    <a href="<?= base_url('surat/rekap?tipe_filter=default') ?>" 
                       class="nav-link <?= $tipe_filter === 'default' ? 'active' : '' ?>">
                        <i class="fas fa-search me-1"></i> Filter Umum
                    </a>
                </li>
                <li class="nav-item" role="presentation">
                    <a href="<?= base_url('surat/rekap?tipe_filter=tanggal') ?>" 
                       class="nav-link <?= $tipe_filter === 'tanggal' ? 'active' : '' ?>">
                        <i class="fas fa-calendar-alt me-1"></i> Filter Tanggal
                    </a>
                </li>
            </ul>

            <!-- Filter Forms -->
            <div class="tab-content p-3 border border-top-0 rounded-bottom mb-4" style="background-color: #f8f9fa;">
                <!-- General Filter -->
                <?php if ($tipe_filter === 'default'): ?>
                    <form action="<?= base_url('surat/rekap') ?>" method="get" class="row g-3">
                        <input type="hidden" name="tipe_filter" value="default">

                        <div class="col-md-2">
                            <label for="tahun" class="form-label small fw-bold">Tahun</label>
                            <select name="tahun" class="form-select form-select-sm">
                                <option value="">Semua Tahun</option>
                                <?php foreach ($daftarTahun as $y): ?>
                                    <option value="<?= $y ?>" <?= $tahun == $y ? 'selected' : '' ?>><?= $y ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="col-md-2">
                            <label for="bulan" class="form-label small fw-bold">Bulan</label>
                            <select name="bulan" class="form-select form-select-sm">
                                <option value="">Semua Bulan</option>
                                <?php
                                $bulanIndo = [
                                    '01' => 'Januari', '02' => 'Februari', '03' => 'Maret',
                                    '04' => 'April', '05' => 'Mei', '06' => 'Juni',
                                    '07' => 'Juli', '08' => 'Agustus', '09' => 'September',
                                    '10' => 'Oktober', '11' => 'November', '12' => 'Desember'
                                ];
                                foreach ($bulanIndo as $key => $value) : ?>
                                    <option value="<?= $key ?>" <?= ($key == ($bulan ?? '')) ? 'selected' : '' ?>><?= $value ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="col-md-2">
                            <label class="form-label small fw-bold">Pengirim</label>
                            <input name="pengirim" value="<?= esc($pengirim) ?>" class="form-control form-control-sm" placeholder="Cari pengirim...">
                        </div>

                        <div class="col-md-2">
                            <label class="form-label small fw-bold">Penerima</label>
                            <input name="penerima" value="<?= esc($penerima) ?>" class="form-control form-control-sm" placeholder="Cari penerima...">
                        </div>

                        <div class="col-md-2">
                            <label class="form-label small fw-bold">Divisi</label>
                            <select name="divisi" class="form-select form-select-sm">
                                <option value="">Semua Divisi</option>
                                <?php $divisiList = ['bina mental spritual', 'pelayanan dasar', 'non pelayanan dasar']; ?>
                                <?php foreach ($divisiList as $d): ?>
                                    <option value="<?= $d ?>" <?= $divisi == $d ? 'selected' : '' ?>><?= ucfirst($d) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="col-md-2 d-flex align-items-end">
                            <button type="submit" class="btn btn-primary btn-sm w-100">
                                <i class="fas fa-search me-1"></i> Cari
                            </button>
                        </div>
                    </form>
                <?php endif; ?>

                <!-- Date Filter -->
                <?php if ($tipe_filter === 'tanggal'): ?>
                    <form action="<?= base_url('surat/rekap') ?>" method="get" class="row g-3">
                        <input type="hidden" name="tipe_filter" value="tanggal">

                        <div class="col-md-4">
                            <label for="tanggal_awal" class="form-label small fw-bold">Tanggal Awal</label>
                            <div class="input-group input-group-sm">
                                <span class="input-group-text"><i class="fas fa-calendar"></i></span>
                                <input type="date" name="tanggal_awal" value="<?= esc($tanggal_awal ?? '') ?>" class="form-control">
                            </div>
                        </div>

                        <div class="col-md-4">
                            <label for="tanggal_akhir" class="form-label small fw-bold">Tanggal Akhir</label>
                            <div class="input-group input-group-sm">
                                <span class="input-group-text"><i class="fas fa-calendar"></i></span>
                                <input type="date" name="tanggal_akhir" value="<?= esc($tanggal_akhir ?? '') ?>" class="form-control">
                            </div>
                        </div>

                        <div class="col-md-4 d-flex align-items-end">
                            <button type="submit" class="btn btn-secondary btn-sm w-100">
                                <i class="fas fa-filter me-1"></i> Filter
                            </button>
                        </div>
                    </form>
                <?php endif; ?>
            </div>

            <!-- Action Buttons -->
            <?php if ($filterAktif): ?>
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div class="text-muted small">
                        <i class="fas fa-info-circle me-1"></i> Menampilkan hasil filter
                    </div>
                    <div>
                        <a href="<?= $tipe_filter === 'tanggal' 
                            ? base_url('surat/downloadRekap?tanggal_awal='.$tanggal_awal.'&tanggal_akhir='.$tanggal_akhir.'&tipe_filter=tanggal')
                            : base_url('surat/downloadRekap?tahun='.$tahun.'&bulan='.$bulan.'&pengirim='.$pengirim.'&penerima='.$penerima.'&divisi='.$divisi.'&tipe_filter=default') ?>"
                           class="btn btn-success btn-sm">
                            <i class="fas fa-file-pdf me-1"></i> Export PDF
                        </a>
                    </div>
                </div>
            <?php endif; ?>

            <!-- Results Section -->
            <div class="mt-3">
                <?php if ($filterAktif): ?>
                    <?php if (!empty($surat)): ?>
                        <div class="table-responsive">
                            <table class="table table-hover table-sm">
                                <thead class="table-light">
                                    <tr>
                                        <th width="50">No</th>
                                        <th>Pengirim</th>
                                        <th>Nomor Surat</th>
                                        <th width="120">Tgl. Surat</th>
                                        <th>Perihal</th>
                                        <th width="120">Tgl. Masuk</th>
                                        <th>Penerima</th>
                                        <th width="150">Divisi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $no = 1; foreach ($surat as $s): ?>
                                        <tr class="align-middle">
                                            <td class="text-muted"><?= $no++ ?></td>
                                            <td><?= esc($s['pengirim']) ?></td>
                                            <td>
                                                <span class="badge bg-primary bg-opacity-10 text-primary">
                                                    <?= esc($s['nomor_surat']) ?>
                                                </span>
                                            </td>
                                            <td><?= date('d/m/Y', strtotime($s['tanggal_surat'])) ?></td>
                                            <td class="text-truncate" style="max-width: 200px;" title="<?= esc($s['perihal']) ?>">
                                                <?= esc($s['perihal']) ?>
                                            </td>
                                            <td>
                                                <span class="badge bg-secondary bg-opacity-10 text-secondary">
                                                    <?= date('d/m/Y', strtotime($s['tanggal_masuk'])) ?>
                                                </span>
                                            </td>
                                            <td><?= esc($s['penerima']) ?></td>
                                            <td>
                                                <?php $divisiColor = [
                                                    'bina mental spritual' => 'info',
                                                    'pelayanan dasar' => 'success',
                                                    'non pelayanan dasar' => 'warning'
                                                ][$s['divisi']] ?? 'secondary'; ?>
                                                <span class="badge bg-<?= $divisiColor ?> bg-opacity-10 text-<?= $divisiColor ?>">
                                                    <?= esc(ucfirst($s['divisi'])) ?>
                                                </span>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php else: ?>
                        <div class="text-center py-5">
                            <div class="mb-3">
                                <i class="fas fa-inbox fa-3x text-muted opacity-25"></i>
                            </div>
                            <h5 class="text-muted">Tidak ada surat ditemukan</h5>
                            <p class="text-muted small">Coba gunakan filter yang berbeda</p>
                        </div>
                    <?php endif; ?>
                <?php else: ?>
                    <div class="text-center py-5">
                        <div class="mb-3">
                            <i class="fas fa-filter fa-3x text-primary opacity-25"></i>
                        </div>
                        <h5 class="text-primary">Gunakan Filter</h5>
                        <p class="text-muted">Silakan gunakan filter di atas untuk menampilkan data surat</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection(); ?>