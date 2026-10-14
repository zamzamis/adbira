<?= $this->extend('layout/template'); ?>
<?= $this->section('content'); ?>

<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-lg-6 col-md-8 col-12">

            <div class="card shadow-sm rounded-4">
                <div class="card-header bg-primary text-white text-center">
                    <h4 class="mb-0">Registrasi Akun Admin</h4>
                </div>

                <div class="card-body p-4">
                                        
                    <?php if (session()->getFlashdata('success')) : ?>
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <?= session()->getFlashdata('success') ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    <?php endif; ?>

                    <form action="<?= base_url('/registadmin/process') ?>" method="post" class="needs-validation" novalidate>
                        <?= csrf_field() ?>
                        
                        <div class="mb-3">
                            <label for="username" class="form-label">Username</label>
                            <input type="text" name="username" class="form-control <?= session('errors.username') ? 'is-invalid' : '' ?>" 
                                   id="username" value="<?= old('username') ?>" required>
                            <div class="invalid-feedback">
                                <?= session('errors.username') ?? 'Username wajib diisi' ?>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" name="password" class="form-control <?= session('errors.password') ? 'is-invalid' : '' ?>" 
                                   id="password" required>
                            <div class="invalid-feedback">
                                <?= session('errors.password') ?? 'Password wajib diisi' ?>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="password_conf" class="form-label">Konfirmasi Password</label>
                            <input type="password" name="password_conf" class="form-control <?= session('errors.password_conf') ? 'is-invalid' : '' ?>" 
                                   id="password_conf" required>
                            <div class="invalid-feedback">
                                <?= session('errors.password_conf') ?? 'Konfirmasi password wajib diisi' ?>
                            </div>
                        </div>

                        <div class="d-grid gap-2 mt-4">
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-person-plus"></i> Daftar Akun Admin
                            </button>
                        </div>
                    </form>

                </div>
            </div>

        </div>
    </div>
</div>

<?= $this->endSection(); ?>