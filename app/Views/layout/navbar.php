<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm sticky-top">
    <div class="container">
        <a class="navbar-brand d-flex align-items-center" href="<?= base_url('/home'); ?>">
            <img src="<?= base_url('img/ADBIRA.png'); ?>" alt="ADBIRA Logo" class="me-2" style="height: 40px;">
            <span class="fw-bold">ADBIRA</span>
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
            data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
            aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mx-auto mx-lg-0 ms-lg-auto text-center">

                <?php if (session()->get('role') == 'admin') : ?>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= base_url('/surat'); ?>">📋 Daftar Surat</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= base_url('/surat/rekap'); ?>">🗂️ Rekap Surat</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= base_url('/akun'); ?>">
                            👤 Daftar Akun
                            <?php if (!empty($pendingCount)) : ?>
                                (<?= $pendingCount; ?>)
                            <?php endif; ?>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= base_url('/maintain') ?>">
                            ⚙️ Maintain
                        </a>
                    </li>
                <?php elseif (session()->get('role') == 'user') : ?>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= base_url('/home'); ?>">🏠 Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= base_url('/surat'); ?>">📋 Daftar Surat</a>
                    </li>
                <?php endif; ?>

                <li class="nav-item">
                    <a class="nav-link text-danger fw-semibold" href="<?= base_url('/logout'); ?>">🚪 Logout</a>
                </li>
            </ul>
        </div>
    </div>
</nav>