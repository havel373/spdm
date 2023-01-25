<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
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
                'nama' => 'Orang',
                'email' => 'orang@gmail.com',
                'password' => Hash::make('password'),
            ],
            [
                'nama' => 'Mahasiswa1',
                'email' => 'mahasiswa1@gmail.com',
                'password' => Hash::make('password'),
            ],
            [
                'nama' => 'Manusia',
                'email' => 'manusia@gmail.com',
                'password' => Hash::make('password'),
            ],
        );
        foreach($data AS $d){
            User::create([
                'nama' =>  $d['nama'],
                'email' =>  $d['email'],
                'password' =>  $d['password'],
                'email_verified_at' => now(),
            ]);
        }
    }
}
