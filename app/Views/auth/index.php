<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>

<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-lg-10 col-12">

            <!-- Flash Message -->
            <?php if (session()->getFlashdata('success')): ?>
                <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
                    <?= session()->getFlashdata('success'); ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>

            <!-- Tombol Tambah Akun Admin -->
            <div class="d-flex justify-content-end mb-4">
                <a href="<?= base_url('/registadmin') ?>" class="btn btn-success shadow-sm">
                    <i class="bi bi-person-plus me-2"></i>Tambah Akun Admin
                </a>
            </div>

            <!-- Card: Pending Users -->
            <div class="card shadow-sm rounded mb-5">
                <div class="card-header bg-primary text-white text-center">
                    <h5 class="mb-0">Daftar Permintaan Akun (Pending)</h5>
                </div>
                <div class="card-body">
                    <?php if (empty($pendingUsers)) : ?>
                        <div class="alert alert-info text-center mb-0">
                            Tidak ada permintaan akun yang pending.
                        </div>
                    <?php else : ?>
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover align-middle mb-0">
                                <thead class="table-light text-center">
                                    <tr>
                                        <th style="width: 5%;">No</th>
                                        <th>Username</th>
                                        <th style="width: 30%;">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($pendingUsers as $index => $user) : ?>
                                        <tr>
                                            <td class="text-center"><?= $index + 1 ?></td>
                                            <td><?= esc($user['username']) ?></td>
                                            <td>
                                                <div class="d-flex flex-column flex-md-row gap-2 justify-content-center">
                                                    <a href="<?= base_url('akun/approve/' . $user['id']) ?>" class="btn btn-outline-success btn-sm w-100 w-md-auto">
                                                        <i class="bi bi-check-circle"></i> Terima
                                                    </a>
                                                    <a href="<?= base_url('akun/delete/' . $user['id']); ?>" class="btn btn-outline-danger btn-sm w-100 w-md-auto" onclick="return confirm('Apakah Anda yakin ingin menolak dan menghapus akun ini?');">
                                                        <i class="bi bi-x-circle"></i> Tolak
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Card: Akun Aktif -->
            <div class="card shadow-sm rounded">
                <div class="card-header bg-secondary text-white text-center">
                    <h5 class="mb-0">Daftar Akun Pengguna</h5>
                </div>
                <div class="card-body">
                    <?php if (empty($akun)) : ?>
                        <div class="alert alert-warning text-center mb-0">
                            Tidak ada data akun yang ditemukan.
                        </div>
                    <?php else : ?>
                        <div class="table-responsive">
                            <table class="table table-hover table-bordered align-middle mb-0">
                                <thead class="table-light text-center">
                                    <tr>
                                        <th style="width: 5%;">No</th>
                                        <th>Username</th>
                                        <th>Password</th>
                                        <th style="width: 15%;">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($akun as $index => $a) : ?>
                                        <tr>
                                            <td class="text-center"><?= $index + 1 ?></td>
                                            <td><?= esc($a['username']) ?></td>
                                            <td style="font-family: monospace; font-size: 0.9em;">
                                                <?= esc($a['password']) ?>
                                            </td>
                                            <td>
                                                <div class="d-flex flex-column flex-md-row gap-2 justify-content-center">
                                                    <form action="<?= base_url('akun/' . $a['id']) ?>" method="post" onsubmit="return confirm('Yakin ingin menghapus user ini?');">
                                                        <?= csrf_field(); ?>
                                                        <input type="hidden" name="_method" value="DELETE">
                                                        <button type="submit" class="btn btn-outline-danger btn-sm w-100 w-md-auto">
                                                            <i class="bi bi-trash"></i> Hapus
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

        </div>
    </div>
</div>

<?= $this->endSection(); ?>