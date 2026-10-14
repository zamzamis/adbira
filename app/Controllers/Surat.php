<?php

namespace App\Controllers;

use Dompdf\Dompdf;
use Dompdf\Options;
use App\Models\SuratModel;
use App\Controllers\BaseController;

class Surat extends BaseController
{
    protected $suratModel;

    public function __construct()
    {
        $this->suratModel = new SuratModel();
    }

    public function index()
    {
        $keyword = $this->request->getVar('keyword');
        $perPage = 10; // Tetapkan nilai perPage di controller

        if ($keyword) {
            $surat = $this->suratModel
                ->groupStart()
                ->like('penerima', $keyword)
                ->orLike('perihal', $keyword)
                ->orLike('nomor_surat', $keyword)
                ->orLike('tanggal_masuk', $keyword)
                ->orLike('tanggal_surat', $keyword)
                ->orLike('file', $keyword)
                ->orLike('pengirim', $keyword)
                ->orLike('divisi', $keyword)
                ->groupEnd()
                ->orderBy('tanggal_masuk', 'DESC')
                ->paginate($perPage, 'surat');
        } else {
            $surat = $this->suratModel
                ->orderBy('tanggal_masuk', 'DESC')
                ->paginate($perPage, 'surat');
        }

        $data = [
            'title' => 'Daftar Surat',
            'surat' => $surat,
            'pager' => $this->suratModel->pager,
            'keyword' => $keyword,
            'pendingCount' => $this->pendingCount,
            'perPage' => $perPage // Tambahkan ini ke data yang dikirim ke view
        ];

        return view('surat/index', $data);
    }


    public function create()
    {
        $data = [
            'title' => 'Form Tambah Surat',
            'pendingCount' => $this->pendingCount
        ];
        return view('surat/create', $data);
    }

    public function save()
    {
        $validation = \Config\Services::validation();

        $rules = [
            'pengirim'       => 'required',
            'perihal'        => 'required',
            'nomor_surat'    => 'required',
            'tanggal_surat'  => 'required|valid_date[Y-m-d]',
            'file'           => 'uploaded[file]|max_size[file,10240]|ext_in[file,pdf]|mime_in[file,application/pdf], required'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('error', $validation->listErrors());
        }

        $filePDF = $this->request->getFile('file');
        $namaFile = null;

        if ($filePDF && $filePDF->isValid() && !$filePDF->hasMoved()) {
            // Ambil nama asli file
            $originalName = $filePDF->getClientName();

            // Bersihkan karakter aneh (hanya huruf, angka, titik, dash, underscore)
            $cleanName = preg_replace('/[^a-zA-Z0-9_\-\.]/', '_', $originalName);

            // Buat 6 karakter acak
            $randomPrefix = substr(bin2hex(random_bytes(3)), 0, 6);

            // Gabungkan jadi nama file: 6karakter_namaasli.ext
            $namaFile = $randomPrefix . '_' . $cleanName;

            // Pindahkan file
            $filePDF->move('file', $namaFile);
        }


        $penerima = session()->get('username');

        $this->suratModel->save([
            'pengirim'       => $this->request->getVar('pengirim'),
            'penerima'       => $penerima,
            'perihal'        => $this->request->getVar('perihal'),
            'divisi'         => $this->request->getVar('divisi'),
            'nomor_surat'    => $this->request->getVar('nomor_surat'),
            'tanggal_surat'  => $this->request->getVar('tanggal_surat'),
            'file'           => $namaFile
        ]);

        session()->setFlashdata('success', 'Surat berhasil ditambahkan!');

        return redirect()->to(session()->get('role') === 'admin' ? '/surat' : '/home');
    }





    public function delete($id)
    {
        $surat = $this->suratModel->find($id);

        if ($surat && $surat['file']) {
            @unlink('file/' . $surat['file']);
        }

        $this->suratModel->delete($id);

        // Ambil nilai page_surat dari query string
        $page = $this->request->getGet('page_surat') ?? 1;

        session()->setFlashdata('success', 'Surat berhasil dihapus!');
        return redirect()->to('/surat?page_surat=' . $page);
    }




    public function edit($id)
    {
        $data = [
            'title' => 'Edit Data',
            'pendingCount' => $this->pendingCount,
            'surat' => $this->suratModel->find($id)
        ];

        return view('surat/edit', $data);
    }

    public function update($id)
    {
        $validation = \Config\Services::validation();

        $rules = [
            'pengirim'       => 'required',
            'perihal'        => 'required',
            'nomor_surat'    => 'required',
            'tanggal_surat'  => 'required|valid_date[Y-m-d]',
            'file'           => 'max_size[file,10240]|ext_in[file,pdf]|mime_in[file,application/pdf]'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('error', $validation->listErrors());
        }

        $filePDF = $this->request->getFile('file');
        $suratLama = $this->suratModel->find($id);

        $namaFile = $suratLama['file']; // default: pakai file lama

        if ($filePDF && $filePDF->isValid() && !$filePDF->hasMoved()) {
            $originalName = $filePDF->getClientName();
            $cleanName = preg_replace('/[^a-zA-Z0-9_\-\.]/', '_', $originalName);
            $randomPrefix = substr(bin2hex(random_bytes(3)), 0, 6);
            $namaFile = $randomPrefix . '_' . $cleanName;

            $filePDF->move('file', $namaFile);

            // Hapus file lama
            if (!empty($suratLama['file']) && file_exists('file/' . $suratLama['file'])) {
                unlink('file/' . $suratLama['file']);
            }
        }


        $penerima = session()->get('username');

        $this->suratModel->save([
            'id'             => $id,
            'pengirim'       => $this->request->getVar('pengirim'),
            'penerima'       => $penerima,
            'perihal'        => $this->request->getVar('perihal'),
            // Jangan update penerima, ambil dari data lama
            'penerima'       => $suratLama['penerima'],
            'nomor_surat'    => $this->request->getVar('nomor_surat'),
            'tanggal_surat'  => $this->request->getVar('tanggal_surat'),
            'file'           => $namaFile
        ]);

        session()->setFlashdata('success', 'Surat berhasil diupdate!');

        return redirect()->to(session()->get('role') === 'admin' ? '/surat' : '/surat');
    }




    public function detail($id)
    {
        $data = [
            'surat' => $this->suratModel->find($id),
            'title' => 'Detail Surat',
            'pendingCount' => $this->pendingCount
        ];

        return view('surat/detail', $data);
    }

    public function rekap()
    {
        $request = \Config\Services::request();
        $tipeFilter = $request->getGet('tipe_filter') ?? 'default';

        $suratModel = new \App\Models\SuratModel();
        $surat = [];
        $filterAktif = false;

        // Cek apakah ada parameter filter yang diisi
        if ($tipeFilter === 'tanggal') {
            $tanggalAwal = $request->getGet('tanggal_awal');
            $tanggalAkhir = $request->getGet('tanggal_akhir');

            if ($tanggalAwal && $tanggalAkhir) {
                $surat = $suratModel->filterByTanggalMasuk($tanggalAwal, $tanggalAkhir);
                $filterAktif = true;
            }
        } else {
            $tahun = $request->getGet('tahun');
            $bulan = $request->getGet('bulan');
            $pengirim = $request->getGet('pengirim');
            $penerima = $request->getGet('penerima');
            $divisi = $request->getGet('divisi');
            $perihal = $request->getGet('perihal');

            // Cek apakah ada parameter filter yang diisi
            if ($tahun || $bulan || $pengirim || $penerima || $divisi || $perihal) {
                $surat = $suratModel->filterSurat($tahun, $bulan, $pengirim, $penerima, $divisi, $perihal);
                $filterAktif = true;
            }
        }

        $data = [
            'title' => 'Rekap Surat',
            'surat' => $surat,
            'daftarTahun' => $suratModel->getTahunSurat(),
            'tipe_filter' => $tipeFilter,
            'filterAktif' => $filterAktif,

            // Form values
            'tahun' => $request->getGet('tahun'),
            'bulan' => $request->getGet('bulan'),
            'pengirim' => $request->getGet('pengirim'),
            'penerima' => $request->getGet('penerima'),
            'divisi' => $request->getGet('divisi'),
            'perihal' => $request->getGet('perihal'),
            'tanggal_awal' => $request->getGet('tanggal_awal'),
            'tanggal_akhir' => $request->getGet('tanggal_akhir'),
        ];

        return view('surat/rekap', $data);
    }

    public function downloadRekap()
    {
        $request = \Config\Services::request();
        $tipe = $request->getGet('tipe_filter') ?? 'default';
        $suratModel = new \App\Models\SuratModel();

        if ($tipe === 'tanggal') {
            $tanggal_awal = $request->getGet('tanggal_awal');
            $tanggal_akhir = $request->getGet('tanggal_akhir');

            if (!$tanggal_awal || !$tanggal_akhir) {
                return redirect()->back()->with('error', 'Tanggal awal dan akhir harus diisi');
            }

            $dataSurat = $suratModel->filterByTanggalMasuk($tanggal_awal, $tanggal_akhir);
            $judul = "Rekap Surat ($tanggal_awal s/d $tanggal_akhir)";
        } else {
            $tahun = $request->getGet('tahun');
            $bulan = $request->getGet('bulan');
            $pengirim = $request->getGet('pengirim');
            $penerima = $request->getGet('penerima');
            $divisi = $request->getGet('divisi');
            $perihal = $request->getGet('perihal');

            $dataSurat = $suratModel->filterSurat($tahun, $bulan, $pengirim, $penerima, $divisi, $perihal);
            $judul = "Rekap Surat";
            $judul .= $tahun ? " Tahun $tahun" : "";
            $judul .= $bulan ? " Bulan $bulan" : "";
        }

        // Load Dompdf
        $dompdf = new \Dompdf\Dompdf();
        $html = view('surat/rekap_pdf', [
            'surat' => $dataSurat,
            'judul' => $judul
        ]);

        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'landscape');
        $dompdf->render();

        // Output the generated PDF
        $dompdf->stream('rekap-surat.pdf', ['Attachment' => true]);

        exit();
    }
}
