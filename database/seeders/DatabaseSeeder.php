<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\User;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $users = [
            // Tim IT (1 Admin & 6 Teknisi)
            [
                'name' => 'Abid',
                'email' => 'abid@gmail.com',
                'password' => Hash::make('password123'),
                'role' => 'admin',
            ],
            [
                'name' => 'Tsalis',
                'email' => 'tsalis@gmail.com',
                'password' => Hash::make('password123'),
                'role' => 'support',
            ],
            [
                'name' => 'Fajar',
                'email' => 'fajar@gmail.com',
                'password' => Hash::make('password123'),
                'role' => 'support',
            ],
            [
                'name' => 'Rizki',
                'email' => 'rizki@gmail.com',
                'password' => Hash::make('password123'),
                'role' => 'support',
            ],
            [
                'name' => 'Ahmad',
                'email' => 'ahmad@gmail.com',
                'password' => Hash::make('password123'),
                'role' => 'support',
            ],
            [
                'name' => 'Dimas',
                'email' => 'dimas@gmail.com',
                'password' => Hash::make('password123'),
                'role' => 'support',
            ],
            [
                'name' => 'Farhan',
                'email' => 'farhan@gmail.com',
                'password' => Hash::make('password123'),
                'role' => 'support',
            ],

            // 40 Karyawan/User Pelapor
            [
                'name' => 'Siti Aisyah',
                'email' => 'siti.aisyah@gmail.com',
                'password' => Hash::make('password123'),
                'role' => 'user',
            ],
            [
                'name' => 'Muhammad Ilham',
                'email' => 'muhammad.ilham@gmail.com',
                'password' => Hash::make('password123'),
                'role' => 'user',
            ],
            [
                'name' => 'Dewi Rahmawati',
                'email' => 'dewi.rahmawati@gmail.com',
                'password' => Hash::make('password123'),
                'role' => 'user',
            ],
            [
                'name' => 'Eko Prasetyo',
                'email' => 'eko.prasetyo@gmail.com',
                'password' => Hash::make('password123'),
                'role' => 'user',
            ],
            [
                'name' => 'Nur Halimah',
                'email' => 'nur.halimah@gmail.com',
                'password' => Hash::make('password123'),
                'role' => 'user',
            ],
            [
                'name' => 'Agus Widodo',
                'email' => 'agus.widodo@gmail.com',
                'password' => Hash::make('password123'),
                'role' => 'user',
            ],
            [
                'name' => 'Lailatul Fitriyah',
                'email' => 'lailatul.fitriyah@gmail.com',
                'password' => Hash::make('password123'),
                'role' => 'user',
            ],
            [
                'name' => 'Hendra Kurniawan',
                'email' => 'hendra.kurniawan@gmail.com',
                'password' => Hash::make('password123'),
                'role' => 'user',
            ],
            [
                'name' => 'Yuni Kartika',
                'email' => 'yuni.kartika@gmail.com',
                'password' => Hash::make('password123'),
                'role' => 'user',
            ],
            [
                'name' => 'Budi Santoso',
                'email' => 'budi.santoso@gmail.com',
                'password' => Hash::make('password123'),
                'role' => 'user',
            ],
            [
                'name' => 'Rina Marlina',
                'email' => 'rina.marlina@gmail.com',
                'password' => Hash::make('password123'),
                'role' => 'user',
            ],
            [
                'name' => 'Wahyu Setiawan',
                'email' => 'wahyu.setiawan@gmail.com',
                'password' => Hash::make('password123'),
                'role' => 'user',
            ],
            [
                'name' => 'Fitri Handayani',
                'email' => 'fitri.handayani@gmail.com',
                'password' => Hash::make('password123'),
                'role' => 'user',
            ],
            [
                'name' => 'Dwi Putra',
                'email' => 'dwi.putra@gmail.com',
                'password' => Hash::make('password123'),
                'role' => 'user',
            ],
            [
                'name' => 'Anisa Nurjanah',
                'email' => 'anisa.nurjanah@gmail.com',
                'password' => Hash::make('password123'),
                'role' => 'user',
            ],
            [
                'name' => 'Rudi Hartono',
                'email' => 'rudi.hartono@gmail.com',
                'password' => Hash::make('password123'),
                'role' => 'user',
            ],
            [
                'name' => 'Sri Mulyani',
                'email' => 'sri.mulyani@gmail.com',
                'password' => Hash::make('password123'),
                'role' => 'user',
            ],
            [
                'name' => 'Bambang Irawan',
                'email' => 'bambang.irawan@gmail.com',
                'password' => Hash::make('password123'),
                'role' => 'user',
            ],
            [
                'name' => 'Nurul Aini',
                'email' => 'nurul.aini@gmail.com',
                'password' => Hash::make('password123'),
                'role' => 'user',
            ],
            [
                'name' => 'Andi Firmansyah',
                'email' => 'andi.firmansyah@gmail.com',
                'password' => Hash::make('password123'),
                'role' => 'user',
            ],
            [
                'name' => 'Mega Putri',
                'email' => 'mega.putri@gmail.com',
                'password' => Hash::make('password123'),
                'role' => 'user',
            ],
            [
                'name' => 'Sugiyanto',
                'email' => 'sugiyanto@gmail.com',
                'password' => Hash::make('password123'),
                'role' => 'user',
            ],
            [
                'name' => 'Kholifah',
                'email' => 'kholifah@gmail.com',
                'password' => Hash::make('password123'),
                'role' => 'user',
            ],
            [
                'name' => 'Arif Rahman',
                'email' => 'arif.rahman@gmail.com',
                'password' => Hash::make('password123'),
                'role' => 'user',
            ],
            [
                'name' => 'Indah Permata',
                'email' => 'indah.permata@gmail.com',
                'password' => Hash::make('password123'),
                'role' => 'user',
            ],
            [
                'name' => 'Joko Susilo',
                'email' => 'joko.susilo@gmail.com',
                'password' => Hash::make('password123'),
                'role' => 'user',
            ],
            [
                'name' => 'Ratna Dewi',
                'email' => 'ratna.dewi@gmail.com',
                'password' => Hash::make('password123'),
                'role' => 'user',
            ],
            [
                'name' => 'Muhamad Fauzi',
                'email' => 'muhamad.fauzi@gmail.com',
                'password' => Hash::make('password123'),
                'role' => 'user',
            ],
            [
                'name' => 'Wulan Sari',
                'email' => 'wulan.sari@gmail.com',
                'password' => Hash::make('password123'),
                'role' => 'user',
            ],
            [
                'name' => 'Teguh Prasetya',
                'email' => 'teguh.prasetya@gmail.com',
                'password' => Hash::make('password123'),
                'role' => 'user',
            ],
            [
                'name' => 'Sari Rahayu',
                'email' => 'sari.rahayu@gmail.com',
                'password' => Hash::make('password123'),
                'role' => 'user',
            ],
            [
                'name' => 'Doni Setiawan',
                'email' => 'doni.setiawan@gmail.com',
                'password' => Hash::make('password123'),
                'role' => 'user',
            ],
            [
                'name' => 'Umi Kulsum',
                'email' => 'umi.kulsum@gmail.com',
                'password' => Hash::make('password123'),
                'role' => 'user',
            ],
            [
                'name' => 'Hendri Saputra',
                'email' => 'hendri.saputra@gmail.com',
                'password' => Hash::make('password123'),
                'role' => 'user',
            ],
            [
                'name' => 'Lutfiah Azzahra',
                'email' => 'lutfiah.azzahra@gmail.com',
                'password' => Hash::make('password123'),
                'role' => 'user',
            ],
            [
                'name' => 'Sigit Wibowo',
                'email' => 'sigit.wibowo@gmail.com',
                'password' => Hash::make('password123'),
                'role' => 'user',
            ],
            [
                'name' => 'Nadia Safitri',
                'email' => 'nadia.safitri@gmail.com',
                'password' => Hash::make('password123'),
                'role' => 'user',
            ],
            [
                'name' => 'Rizal Maulana',
                'email' => 'rizal.maulana@gmail.com',
                'password' => Hash::make('password123'),
                'role' => 'user',
            ],
            [
                'name' => 'Tri Wahyuni',
                'email' => 'tri.wahyuni@gmail.com',
                'password' => Hash::make('password123'),
                'role' => 'user',
            ],
            [
                'name' => 'Bayu Aditya',
                'email' => 'bayu.aditya@gmail.com',
                'password' => Hash::make('password123'),
                'role' => 'user',
            ],
        ];

        foreach ($users as $userData) {
            User::updateOrCreate(
                ['email' => $userData['email']],
                $userData
            );
        }

        $this->call(TicketSeeder::class);
        $this->call(KnowledgeBaseSeeder::class);
    }
}
