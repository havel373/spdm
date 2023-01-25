<?php

namespace Database\Seeders;

use App\Models\Prodi;
use Illuminate\Database\Seeder;

class ProdiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = array(
            [
                'nama' => 'D3 Teknologi Informasi',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama' => 'D3 Teknologi Komputer',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama' => 'Teknologi Rekayasa Perangkat Lunak',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama' => 'S1 Informatika',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama' => 'S1 Manajemen Rekayasa',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama' => 'S1 Sistem Informasi',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama' => 'S1 Teknik Bioproses',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama' => 'S1 eknik Elektro',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        );
        foreach($data AS $d){
            Prodi::create([
                'nama' => $d['nama'],
                'created_at' => $d['created_at'],
                'updated_at' => $d['updated_at'],
            ]);
        }
    }
}
