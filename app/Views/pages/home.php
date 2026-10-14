<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>


<style>
    .welcome-container {
        min-height: 80vh;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
    }

    .welcome-heading {
        font-size: 2.5rem;
        font-weight: 700;
        color: #343a40;
        animation: fadeInDown 1s ease;
    }

    @keyframes fadeInDown {
        from {
            opacity: 0;
            transform: translateY(-30px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .flash-card {
        animation: fadeIn 0.5s ease;
    }

    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(-20px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
</style>

<div class="container welcome-container text-center">
    <h1 class="welcome-heading">Selamat Datang, <span class="text-primary"><?= esc(session('username')); ?></span> 👋</h1>

    <?php if (session()->get('role') == 'user') : ?>
        <a href="<?= base_url('surat/create'); ?>" class="btn btn-success mt-4 px-4 py-2 shadow-sm">
            <i class="bi bi-plus-circle"></i> Tambah Surat Masuk
        </a>
    <?php endif; ?>

    <?php if (session()->getFlashdata('success')) : ?>
        <div id="flash-card" class="position-fixed start-50 translate-middle-x flash-card" style="top: 100px; z-index: 1050; width: 90%; max-width: 500px;">
            <div class="card border-success shadow-sm">
                <div class="card-body text-success text-center fw-bold">
                    <?= session()->getFlashdata('success'); ?>
                </div>
            </div>
        </div>
    <?php endif; ?>


    <?php if (session()->getFlashdata('error')) : ?>
        <div id="flash-card" class="position-fixed start-50 translate-middle-x flash-card" style="top: 100px; z-index: 1050; width: 90%; max-width: 500px;">
            <div class="card border-danger shadow-sm">
                <div class="card-body text-danger text-center fw-bold">
                    <?= session()->getFlashdata('error'); ?>
                </div>
            </div>
        </div>
    <?php endif; ?>

    <script>
        setTimeout(() => {
            const flashCard = document.getElementById('flash-card');
            if (flashCard) {
                flashCard.style.transition = 'all 1s ease';
                flashCard.style.transform = 'translateY(-100px)';
                flashCard.style.opacity = '0';
                setTimeout(() => flashCard.remove(), 1000);
            }
        }, 3000);
    </script>


    <?= $this->endSection(); ?>