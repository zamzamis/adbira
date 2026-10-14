<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>

<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-lg-8 col-md-10 col-12">

            <div class="card shadow rounded-4 border-0">
                <div class="card-header bg-primary text-white rounded-top-4 d-flex justify-content-between align-items-center px-4 py-3">
                    <h5 class="mb-0 fw-semibold">Detail Surat</h5>
                    <a href="javascript:history.back()" class="btn btn-sm btn-light px-3 shadow-sm">
                        <i class="bi bi-arrow-left me-1"></i> Kembali
                    </a>

                </div>

                <div class="card-body px-4 py-4">
                    <div class="table-responsive mb-4">
                        <table class="table table-borderless align-middle">
                            <tr>
                                <th class="text-muted" style="width: 35%;">Nomor Surat</th>
                                <td><?= esc($surat['nomor_surat']); ?></td>
                            </tr>
                            <tr>
                                <th class="text-muted">Tanggal Surat</th>
                                <td><?= esc($surat['tanggal_surat']); ?></td>
                            </tr>
                            <tr>
                                <th class="text-muted">Tanggal Masuk</th>
                                <td><?= esc($surat['tanggal_masuk']); ?></td>
                            </tr>
                            <tr>
                                <th class="text-muted">Pengirim</th>
                                <td><?= esc($surat['pengirim']); ?></td>
                            </tr>
                            <tr>
                                <th class="text-muted">Penerima</th>
                                <td><?= esc($surat['penerima']); ?></td>
                            </tr>
                            <tr>
                                <th class="text-muted">Divisi</th>
                                <td><?= esc($surat['divisi']); ?></td>
                            </tr>

                            <tr>
                                <th class="text-muted">Perihal</th>
                                <td><?= esc($surat['perihal']); ?></td>
                            </tr>
                        </table>
                    </div>

                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h6 class="mb-0">File Surat</h6>
                        <?php if ($surat['file']): ?>
                            <span class="text-muted small text-break d-block mt-2">
                                <i class="bi bi-file-earmark-text me-1"></i><?= esc($surat['file']); ?>
                            </span>

                        <?php endif; ?>
                    </div>

                    <?php if ($surat['file']): ?>
                        <div class="ratio ratio-4x3 rounded-3 shadow-sm border">
                            <iframe src="<?= base_url('pdfjs/web/viewer.html?file=' . urlencode(base_url('file/' . $surat['file']))); ?>"
                                width="100%" height="600px" style="border: none;" allowfullscreen>
                            </iframe>
                        </div>
                    <?php else: ?>
                        <div class="alert alert-warning rounded-3">
                            <i class="bi bi-exclamation-circle me-1"></i> Tidak ada file PDF tersedia.
                        </div>
                    <?php endif; ?>
                </div>
            </div>

        </div>
    </div>
</div>

<?= $this->endSection(); ?>