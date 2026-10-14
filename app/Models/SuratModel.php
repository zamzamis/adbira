<?php

namespace App\Models;

use CodeIgniter\Model;

class SuratModel extends Model
{
    protected $table = 'surat';         // Nama tabel di database
    protected $primaryKey = 'id';        // Primary key

    protected $allowedFields = ['nomor_surat', 'tanggal_surat', 'pengirim', 'penerima', 'divisi', 'perihal', 'file'];
    // Menambahkan nomor_surat dan tanggal_surat ke allowedFields

    protected $useTimestamps = false;    // Karena kita pakai CURRENT_TIMESTAMP dari database, bukan dari CI

    public function search($keyword)
    {
        return $this->table('surat')
            ->like('nomor_surat', $keyword)   // Tambahkan pencarian nomor surat
            ->orLike('pengirim', $keyword)
            ->orLike('penerima', $keyword)
            ->orLike('perihal', $keyword)
            ->orLike('divisi', $keyword)
            ->orLike('tanggal_surat', $keyword)  // Tambahkan pencarian tanggal surat
            ->orLike('tanggal_masuk', $keyword)  // Tetap bisa cari berdasarkan tanggal masuk
            ->get()
            ->getResultArray();
    }

    public function getTahunSurat()
    {
        $result = $this->db->table('surat')
            ->select('YEAR(tanggal_masuk) AS tahun')
            ->groupBy('tahun')
            ->orderBy('tahun', 'DESC')
            ->get()
            ->getResultArray();

        // Ambil hanya kolom 'tahun' saja
        return array_column($result, 'tahun');
    }



    public function filterSurat($tahun, $bulan, $pengirim, $penerima, $divisi)
    {
        $builder = $this->builder();

        if ($tahun) {
            $builder->where('YEAR(tanggal_masuk)', $tahun);
            if ($bulan) {
                $builder->where('MONTH(tanggal_masuk)', $bulan);
            }
        }

        if ($pengirim) {
            $builder->like('pengirim', $pengirim);
        }

        if ($penerima) {
            $builder->like('penerima', $penerima);
        }

        if ($divisi) {
            $builder->where('divisi', $divisi);
        }

        return $builder->get()->getResultArray();
    }

    public function filterByTanggalMasuk($awal, $akhir)
    {
        $builder = $this->builder();

        if ($awal && $akhir) {
            $builder->where('tanggal_masuk >=', $awal);
            $builder->where('tanggal_masuk <=', $akhir);
        }

        return $builder->get()->getResultArray();
    }
}
