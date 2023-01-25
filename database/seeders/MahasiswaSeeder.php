<?php

namespace Database\Seeders;

use App\Models\Mahasiswa;
use Illuminate\Database\Seeder;

class MahasiswaSeeder extends Seeder
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
                'nim' => '11320011',
                'semester' => 'VI',
                'kelas' => '33TI1',
                'tahun' => '2020',
                'user_id' => 1,
                'prodi' => 1,
            ],
            [
                'nim' => '13320021',
                'semester' => 'IV',
                'kelas' => '33TK2',
                'tahun' => '2021',
                'user_id' => 2,
                'prodi' => 2,
            ],
            [
                'nim' => '11420045',
                'semester' => 'VIII',
                'kelas' => '44TRPL4',
                'tahun' => '2019',
                'user_id' => 3,
                'prodi' => 3,
            ],
        );
        foreach($data AS $d){
            Mahasiswa::create([
                'nim' =>  $d['nim'],
                'semester' =>  $d['semester'],
                'kelas' =>  $d['kelas'],
                'tahun' =>  $d['tahun'],
                'user_id' =>  $d['user_id'],
                'prodi' =>  $d['prodi'],
            ]);
        }
    }
}
