<?php

namespace App\Controllers;

use Dompdf\Dompdf;
use Dompdf\Options;

class Maintain extends \App\Controllers\BaseController
{
    public function index()
    {
        helper('folder');

        $data = [
            'title' => 'Maintain Surat',
            'chartData' => $this->getChartData(),
            'pendingCount' => $this->pendingCount
        ];

        return view('maintain/index', $data);
    }

    private function getChartData()
    {
        $db = \Config\Database::connect();
        $builder = $db->table('surat');

        try {
            $query = $builder->select("MONTH(tanggal_surat) as bulan, COUNT(*) as jumlah")
                ->where('YEAR(tanggal_surat)', date('Y'))
                ->groupBy("MONTH(tanggal_surat)")
                ->get();

            $chartData = array_fill(0, 12, 0);
            foreach ($query->getResultArray() as $item) {
                $chartData[$item['bulan'] - 1] = $item['jumlah'];
            }

            return $chartData;
        } catch (\Exception $e) {
            log_message('error', 'Error getting chart data: ' . $e->getMessage());
            return array_fill(0, 12, 0);
        }
    }

    public function exportSuratToPdf()
    {
        $db = \Config\Database::connect();
        $suratList = $db->table('surat')->get()->getResultArray();

        $html = view('maintain/rekap_pdf', [
            'suratList' => $suratList,
            'tahun' => date('Y')
        ]);

        $options = new Options();
        $options->set('isRemoteEnabled', true);

        $dompdf = new Dompdf($options);
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'landscape');
        $dompdf->render();

        $fileName = 'Rekap_Surat_Akhir_' . date('Y') . '.pdf'; // Standarkan penamaan dengan huruf kapital

        // Langsung stream PDF tanpa menyimpan ke server
        $dompdf->stream($fileName, ['Attachment' => true]);

        exit; // Pastikan tidak ada output lain setelah stream
    }

    public function zipSurat()
    {
        $folderPath = FCPATH . 'file/';
        $zipFileName = 'semua_surat_' . date('Y') . '.zip';

        // Cek apakah folder ada dan ada file di dalamnya
        $files = array_diff(scandir($folderPath), ['.', '..']);
        if (empty($files)) {
            return $this->response->setBody('Tidak ada file surat yang dapat diarsipkan.');
        }

        $zip = new \ZipArchive();

        // Buat file ZIP di sistem sementara
        $tmpZip = tempnam(sys_get_temp_dir(), 'zip');
        if ($zip->open($tmpZip, \ZipArchive::OVERWRITE) !== TRUE) {
            return $this->response->setBody('Gagal membuat file ZIP.');
        }

        // Tambahkan file ke ZIP
        foreach ($files as $file) {
            $filePath = $folderPath . $file;
            if (is_file($filePath)) {
                $zip->addFile($filePath, $file); // nama di dalam ZIP
            }
        }

        $zip->close();

        // Kirim ZIP ke browser
        return $this->response
            ->setHeader('Content-Type', 'application/zip')
            ->setHeader('Content-Disposition', 'attachment; filename="' . $zipFileName . '"')
            ->setHeader('Content-Length', filesize($tmpZip))
            ->setBody(file_get_contents($tmpZip));
    }

    public function clearSurat()
    {
        $db = \Config\Database::connect();
        $fileFolder = FCPATH . 'file/'; // Sesuaikan path folder

        $db->transStart(); // Mulai transaction database

        try {
            // 1. Ambil daftar file dari database sebelum dihapus
            $filesInDatabase = $db->table('surat')
                ->select('file')
                ->get()
                ->getResultArray();

            // 2. Hapus semua data dari tabel surat
            $db->table('surat')->emptyTable();

            // 3. Hapus file fisik yang terkait
            $deletedFilesCount = 0;
            foreach ($filesInDatabase as $file) {
                if (!empty($file['file'])) {
                    $filePath = $fileFolder . $file['file'];
                    if (file_exists($filePath) && is_writable($filePath)) {
                        unlink($filePath);
                        $deletedFilesCount++;
                    }
                }
            }

            $db->transComplete(); // Commit transaction

            // Set flashdata untuk notifikasi
            session()->setFlashdata(
                'success',
                "Berhasil menghapus semua data surat dan {$deletedFilesCount} file fisik"
            );

            return redirect()->back();
        } catch (\Exception $e) {
            $db->transRollback(); // Rollback jika terjadi error

            // Set flashdata error
            session()->setFlashdata(
                'error',
                "Gagal menghapus data: " . $e->getMessage()
            );

            return redirect()->back();
        }
    }
}
