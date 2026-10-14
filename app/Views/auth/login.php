<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>

<style>
    .login-card {
        border: none;
        border-radius: 16px;
        padding: 2rem;
        box-shadow: 0 8px 24px rgba(0, 0, 0, 0.1);
        background-color: #ffffff;
        animation: fadeIn 0.6s ease;
    }

    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(20px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    body {
        background: #f4f6f9;
    }
</style>

<div class="container d-flex justify-content-center align-items-center" style="min-height: 90vh;">
    <div class="col-12 col-sm-8 col-md-6 col-lg-4">

        <div class="login-card">
            <h3 class="text-center mb-4">🔐 Login ADBIRA</h3>


            <?php if (session()->getFlashdata('success')): ?>
                <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
            <?php endif; ?>
            <?php if (session()->getFlashdata('error')): ?>
                <div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
            <?php endif; ?>

            <?php if (session()->getFlashdata('expired')): ?>
                <div class="alert alert-warning"><?= session()->getFlashdata('expired') ?></div>
            <?php endif; ?>




            <form action="/auth/attemptLogin" method="post" novalidate>
                <?= csrf_field() ?>
                <div class="form-floating mb-3">
                    <input type="text" name="username" class="form-control" id="username" placeholder="Username" required>
                    <label for="username">Username</label>
                </div>

                <div class="form-floating mb-3">
                    <input type="password" name="password" class="form-control" id="password" placeholder="Password" required>
                    <label for="password">Password</label>
                </div>

                <button type="submit" class="btn btn-primary w-100 py-2 mb-2">Masuk</button>
            </form>

            <div class="text-center mt-3">
                <small>Belum punya akun?</small>
                <a href="/register" class="btn btn-outline-secondary w-100 mt-2">Daftar Akun</a>
            </div>
        </div>

    </div>
</div>

<?= $this->endSection(); ?>