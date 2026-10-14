<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\RawSql;
use CodeIgniter\Database\Migration;

class CreateSuratTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'unsigned' => true,
                'auto_increment' => true
            ],
            'nomor_surat' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
            ],
            'tanggal_surat' => [
                'type' => 'DATE',
                'null' => true,
            ],
            'tanggal_masuk' => [
                'type'    => 'DATETIME',
                'null'    => false,
                'default' => new RawSql('CURRENT_TIMESTAMP'),
            ],
            'pengirim' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
            ],
            'penerima' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'divisi' => [
                'type' => 'VARCHAR',
                'constraint' => 50,
            ],
            'perihal' => [
                'type' => 'VARCHAR',
                'constraint' => 500,
            ],
            'file' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('surat');
    }


    public function down()
    {
        //
    }
}
