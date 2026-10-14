<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>


<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-lg-8 col-md-10 col-12">

            <div class="card shadow-sm rounded-4">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">Tambah Surat Baru</h4>
                    <a href="<?= base_url('/surat'); ?>" class="btn btn-light btn-sm">
                        <i class="bi bi-arrow-left"></i> Kembali
                    </a>
                </div>

                <div class="card-body p-4">
                    <form action="/surat/save" method="post" enctype="multipart/form-data" class="needs-validation" novalidate>
                        <?= csrf_field() ?>

                        <!-- Nomor Surat -->
                        <div class="mb-3">
                            <label for="nomor_surat" class="form-label">Nomor Surat</label>
                            <input
                                type="text"
                                class="form-control <?= session('errors.nomor_surat') ? 'is-invalid' : '' ?>"
                                id="nomor_surat"
                                name="nomor_surat"
                                value="<?= old('nomor_surat') ?>"
                                required>
                            <?php if (session('errors.nomor_surat')) : ?>
                                <div class="invalid-feedback"><?= session('errors.nomor_surat') ?></div>
                            <?php endif; ?>
                        </div>

                        <!-- Tanggal Surat -->
                        <div class="mb-3">
                            <label for="tanggal_surat" class="form-label">Tanggal Surat</label>
                            <input
                                type="date"
                                class="form-control <?= session('errors.tanggal_surat') ? 'is-invalid' : '' ?>"
                                id="tanggal_surat"
                                name="tanggal_surat"
                                value="<?= old('tanggal_surat') ?>"
                                required>
                            <?php if (session('errors.tanggal_surat')) : ?>
                                <div class="invalid-feedback"><?= session('errors.tanggal_surat') ?></div>
                            <?php endif; ?>
                        </div>

                        <!-- Pengirim -->
                        <div class="mb-3">
                            <label for="pengirim" class="form-label">Pengirim</label>
                            <input
                                type="text"
                                class="form-control <?= session('errors.pengirim') ? 'is-invalid' : '' ?>"
                                id="pengirim"
                                name="pengirim"
                                value="<?= old('pengirim') ?>"
                                required>
                            <?php if (session('errors.pengirim')) : ?>
                                <div class="invalid-feedback"><?= session('errors.pengirim') ?></div>
                            <?php endif; ?>
                        </div>

                        <!-- Divisi -->
                        <div class="mb-3">
                            <label for="divisi" class="form-label">Divisi</label>
                            <select
                                name="divisi"
                                id="divisi"
                                class="form-select <?= session('errors.divisi') ? 'is-invalid' : '' ?>"
                                required>
                                <option value="">-- Pilih Divisi --</option>
                                <option value="Bina Mental Spritual" <?= old('divisi') === 'Bina Mental Spritual' ? 'selected' : '' ?>>Bina Mental Spritual</option>
                                <option value="Pelayanan Dasar" <?= old('divisi') === 'Pelayanan Dasar' ? 'selected' : '' ?>>Pelayanan Dasar</option>
                                <option value="Non Pelayanan Dasar" <?= old('divisi') === 'Non Pelayanan Dasar' ? 'selected' : '' ?>>Non Pelayanan Dasar</option>
                            </select>
                            <?php if (session('errors.divisi')) : ?>
                                <div class="invalid-feedback"><?= session('errors.divisi') ?></div>
                            <?php endif; ?>
                        </div>

                        <!-- Perihal -->
                        <div class="mb-3">
                            <label for="perihal" class="form-label">Perihal</label>
                            <textarea
                                class="form-control <?= session('errors.perihal') ? 'is-invalid' : '' ?>"
                                id="perihal"
                                name="perihal"
                                rows="1"
                                oninput="autoResize(this)"
                                required><?= old('perihal') ?></textarea>
                            <?php if (session('errors.perihal')) : ?>
                                <div class="invalid-feedback"><?= session('errors.perihal') ?></div>
                            <?php endif; ?>
                        </div>

                        <!-- Upload File -->
                        <div class="mb-3">
                            <label for="file" class="form-label">Upload File (PDF, Maks 5MB)</label>
                            <input
                                class="form-control <?= session('errors.file') ? 'is-invalid' : '' ?>"
                                type="file"
                                id="file"
                                name="file"
                                accept="application/pdf"
                                required>
                            <?php if (session('errors.file')) : ?>
                                <div class="invalid-feedback"><?= session('errors.file') ?></div>
                            <?php endif; ?>
                            <div class="form-text">Pastikan file berformat PDF dan tidak melebihi 5MB.</div>
                        </div>

                        <!-- Tombol Submit -->
                        <div class="d-grid gap-2 mt-4">
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-save"></i> Simpan Surat
                            </button>
                        </div>
                    </form>

                </div>
            </div>

        </div>
    </div>
</div>

<script>
    // Bootstrap form validation
    (() => {
        'use strict';
        const forms = document.querySelectorAll('.needs-validation');
        Array.from(forms).forEach(form => {
            form.addEventListener('submit', event => {
                if (!form.checkValidity()) {
                    event.preventDefault();
                    event.stopPropagation();
                }
                form.classList.add('was-validated');
            }, false);
        });
    })();
</script>

<script>
    function autoResize(textarea) {
        textarea.style.height = 'auto';
        textarea.style.height = textarea.scrollHeight + 'px';
    }

    // Bootstrap form validation
    (() => {
        'use strict';
        const forms = document.querySelectorAll('.needs-validation');
        Array.from(forms).forEach(form => {
            form.addEventListener('submit', event => {
                if (!form.checkValidity()) {
                    event.preventDefault();
                    event.stopPropagation();
                }
                form.classList.add('was-validated');
            }, false);
        });
    })();
</script>



<?= $this->endSection(); ?>