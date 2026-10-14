<!DOCTYPE html>
<html>

<head>
    <title>Rekap Surat Tahun <?= $tahun ?></title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            margin: 20px;
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        th, td {
            border: 1px solid #000;
            padding: 6px 8px;
            text-align: left;
            vertical-align: top;
            word-break: break-word;
        }

        th {
            background-color: #f0f0f0;
        }

        /* Optional: Adjust specific column widths */
        th:nth-child(1),
        td:nth-child(1) {
            width: 30px;
            text-align: center;
        }

        th:nth-child(3),
        td:nth-child(3) {
            width: 100px;
        }

        th:nth-child(4),
        td:nth-child(4),
        th:nth-child(6),
        td:nth-child(6) {
            width: 90px;
        }

        th:nth-child(9),
        td:nth-child(9) {
            width: 100px;
        }
    </style>
</head>

<body>
    <h2>Rekap Surat Tahun <?= $tahun ?></h2>

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
                <th>File</th>
            </tr>
        </thead>
        <tbody>
            <?php $no = 1; ?>
            <?php foreach ($suratList as $s): ?>
                <tr>
                    <td><?= $no++ ?></td>
                    <td><?= esc($s['pengirim']) ?></td>
                    <td><?= esc($s['nomor_surat']) ?></td>
                    <td><?= date('d/m/Y', strtotime($s['tanggal_surat'])) ?></td>
                    <td><?= esc($s['perihal']) ?></td>
                    <td><?= date('d/m/Y', strtotime($s['tanggal_masuk'])) ?></td>
                    <td><?= esc($s['penerima']) ?></td>
                    <td><?= esc($s['divisi']) ?></td>
                    <td><?= esc($s['file']) ?></td>
                </tr>
            <?php endforeach ?>
        </tbody>
    </table>
</body>

</html>
