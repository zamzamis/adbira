<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>

<div class="container my-4">
    <div class="row justify-content-center">
        <div class="col-md-8">

            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">Edit Surat</h4>
                </div>

                <div class="card-body">

                    <?php if (session()->getFlashdata('error')) : ?>
                        <div class="alert alert-danger">
                            <?= session()->getFlashdata('error'); ?>
                        </div>
                    <?php endif; ?>

                    <?php if (session()->getFlashdata('success')) : ?>
                        <div class="alert alert-success">
                            <?= session()->getFlashdata('success'); ?>
                        </div>
                    <?php endif; ?>

                    <form action="/surat/update/<?= $surat['id']; ?>" method="post" enctype="multipart/form-data">
                        <?= csrf_field() ?>

                        <div class="mb-3">
                            <label for="nomor_surat" class="form-label">Nomor Surat</label>
                            <input type="text" class="form-control" id="nomor_surat" name="nomor_surat" value="<?= $surat['nomor_surat']; ?>" required>
                        </div>

                        <div class="mb-3">
                            <label for="tanggal_surat" class="form-label">Tanggal Surat</label>
                            <input type="date" class="form-control" id="tanggal_surat" name="tanggal_surat" value="<?= $surat['tanggal_surat']; ?>" required>
                        </div>

                        <div class="mb-3">
                            <label for="pengirim" class="form-label">Pengirim</label>
                            <input type="text" class="form-control" id="pengirim" name="pengirim" value="<?= $surat['pengirim']; ?>" required>
                        </div>

                        <div class="mb-3">
                            <label for="penerima" class="form-label">Penerima</label>
                            <input type="text" class="form-control" id="penerima" name="penerima" value="<?= $surat['penerima']; ?>" readonly>
                        </div>

                        <div class="mb-3">
                            <label for="divisi" class="form-label">Divisi</label>
                            <select name="divisi" id="divisi" class="form-select" required>
                                <option value="">-- Pilih Divisi --</option>
                                <option value="Bina Mental Spritual" <?= $surat['divisi'] === 'Bina Mental Spritual' ? 'selected' : '' ?>>Bina Mental Spritual</option>
                                <option value="Pelayanan Dasar" <?= $surat['divisi'] === 'Pelayanan Dasar' ? 'selected' : '' ?>>Pelayanan Dasar</option>
                                <option value="Non Pelayanan Dasar" <?= $surat['divisi'] === 'Non Pelayanan Dasar' ? 'selected' : '' ?>>Non Pelayanan Dasar</option>
                            </select>
                        </div>


                        <div class="mb-3">
                            <label for="perihal" class="form-label">Perihal</label>
                            <input type="text" class="form-control" id="perihal" name="perihal" value="<?= $surat['perihal']; ?>" required>
                        </div>

                        <div class="mb-3">
                            <label for="file" class="form-label">Upload File (PDF, Maks 5MB)</label>
                            <input class="form-control" type="file" id="file" name="file" accept="application/pdf">
                            <small class="text-muted">Biarkan kosong jika tidak ingin mengganti file.</small>
                        </div>

                        <div class="d-flex justify-content-between">
                            <button type="button" class="btn btn-outline-secondary" onclick="window.history.back();">
                                <i class="bi bi-arrow-left"></i> Kembali
                            </button>
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-save"></i> Update Surat
                            </button>
                        </div>
                    </form>

                </div>
            </div>

        </div>
    </div>
</div>


<?= $this->endSection(); ?>