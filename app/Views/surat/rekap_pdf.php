<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title><?= $judul ?></title>
    <style>
        body { font-family: Arial, sans-serif; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
        .header { text-align: center; margin-bottom: 20px; }
    </style>
</head>
<body>
    <div class="header">
        <h2><?= $judul ?></h2>
        <p>Dicetak pada: <?= date('d-m-Y H:i:s') ?></p>
    </div>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Pengirim</th>
                <th>Nomor Surat</th>
                <th>Tanggal Surat</th>
                <th>Perihal</th>
                <th>Tanggal Masuk</th>
                <th>Penerima</th>
                <th>Divisi</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($surat)): ?>
                <?php $no = 1; foreach ($surat as $s): ?>
                    <tr>
                        <td><?= $no++ ?></td>
                        <td><?= esc($s['pengirim']) ?></td>
                        <td><?= esc($s['nomor_surat']) ?></td>
                        <td><?= esc($s['tanggal_surat']) ?></td>
                        <td><?= esc($s['perihal']) ?></td>
                        <td><?= date('d-m-Y', strtotime($s['tanggal_masuk'])) ?></td>
                        <td><?= esc($s['penerima']) ?></td>
                        <td><?= esc($s['divisi']) ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="8" style="text-align: center;">Tidak ada data surat</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</body>
</html>