<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>

<div class="container my-4">
    <div class="row justify-content-center">
        <div class="col-md-12">

            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">Daftar Surat</h4>
                    <a href="/surat/create" class="btn btn-light btn-sm">
                        <i class="bi bi-plus-circle"></i> Tambah Surat
                    </a>
                </div>

                <div class="card-body">

                    <form action="/surat" method="get" class="mb-3">
                        <div class="input-group">
                            <input type="text" class="form-control" placeholder="Cari surat..." name="keyword" value="<?= esc($keyword ?? '') ?>">
                            <button class="btn btn-primary" type="submit">
                                <i class="bi bi-search"></i> Cari
                            </button>
                            <?php if (!empty($keyword)) : ?>
                                <a href="/surat" class="btn btn-outline-secondary">
                                    <i class="bi bi-x-circle"></i> Reset
                                </a>
                            <?php endif; ?>
                        </div>
                    </form>

                    <?php if (session()->getFlashdata('success')): ?>
                        <div class="alert alert-success">
                            <?= session()->getFlashdata('success'); ?>
                        </div>
                    <?php endif; ?>

                    <?php if (empty($surat)) : ?>
                        <div class="alert alert-warning">
                            <?= empty($keyword) ? 'Belum ada data surat' : 'Data tidak ditemukan' ?>
                        </div>
                    <?php else : ?>
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover align-middle text-center">
                                <thead class="table-light">
                                    <tr>
                                        <th style="width: 5%;">No</th>
                                        <th style="width: 15%;">Tanggal Masuk</th>
                                        <th style="min-width: 120px;">Penerima</th>
                                        <th style="min-width: 150px;">Perihal</th>
                                        <th style="width: 15%;">File</th>
                                        <th style="width: 20%;">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($surat as $index => $s) : ?>
                                        <tr onclick="window.location='/surat/detail/<?= $s['id']; ?>'" style="cursor: pointer;">
                                            <td><?= $index + 1 + ($pager->getPerPage('surat') * ($pager->getCurrentPage('surat') - 1)) ?></td>
                                            <td><?= date('Y-m-d', strtotime($s['tanggal_masuk'])) ?></td>

                                            <td class="text-start text-truncate" style="max-width: 140px;" title="<?= esc($s['penerima']) ?>">
                                                <?= esc($s['penerima']) ?>
                                            </td>

                                            <td class="text-start text-truncate" style="max-width: 180px;" title="<?= esc($s['perihal']) ?>">
                                                <?= esc($s['perihal']) ?>
                                            </td>

                                            <td>
                                                <?php if ($s['file']) : ?>
                                                    <a href="<?= base_url('file/' . esc($s['file'])) ?>" target="_blank" class="btn btn-sm btn-outline-dark mb-1" onclick="event.stopPropagation()">
                                                        <i class="bi bi-file-earmark-pdf"></i> PDF
                                                    </a>
                                                    <div class="small text-muted text-truncate" style="max-width: 120px;" title="<?= esc($s['file']) ?>">
                                                        <i class="bi bi-file-earmark-text me-1"></i><?= esc($s['file']) ?>
                                                    </div>
                                                <?php else : ?>
                                                    <span class="text-muted">-</span>
                                                <?php endif; ?>
                                            </td>

                                            <td onclick="event.stopPropagation()">
                                                <div class="d-grid d-md-flex gap-2">
                                                    <?php if (session()->get('role') === 'user') : ?>
                                                        <a href="/surat/detail/<?= $s['id']; ?>" class="btn btn-outline-info btn-sm w-100 w-md-auto">
                                                            <i class="bi bi-eye"></i> Detail
                                                        </a>
                                                    <?php else : ?>
                                                        <a href="/surat/edit/<?= $s['id']; ?>" class="btn btn-outline-warning btn-sm w-100 w-md-auto">
                                                            <i class="bi bi-pencil-square"></i> Edit
                                                        </a>

                                                        <form action="/surat/<?= $s['id']; ?>?page_surat=<?= $_GET['page_surat'] ?? 1; ?>" method="post" class="w-100 w-md-auto">
                                                            <?= csrf_field(); ?>
                                                            <input type="hidden" name="_method" value="DELETE">
                                                            <button type="submit" class="btn btn-outline-danger btn-sm w-100 w-md-auto" onclick="return confirm('Apakah anda yakin ingin menghapus surat ini?');">
                                                                <i class="bi bi-trash"></i> Hapus
                                                            </button>
                                                        </form>
                                                    <?php endif; ?>
                                                </div>
                                            </td>

                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>

                        <div class="mt-3">
                            <?= $pager->links('surat', 'bootstrap_full') ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection(); ?>