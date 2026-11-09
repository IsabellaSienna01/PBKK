<?php

namespace Database\Seeders;

use App\Models\IdeAgent;
use App\Models\Mahasiswa;
use App\Models\MataKuliah;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;

class AcademicSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create('id_ID');

        // 1. Data Mahasiswa Owner (Prioritas Pertama)
        Mahasiswa::firstOrCreate(
            ['nrp' => '5025241199'],
            [
                'nama' => 'Isabella Sienna Sulisthio',
                'email' => 'isabella@student.its.ac.id',
                'jurusan' => 'Teknik Informatika',
                'angkatan' => 2024,
                'ipk' => 3.92,
                'status' => 'Aktif',
            ]
        );

        // 2. Puluhan Data Mahasiswa Dummy Menggunakan Faker
        $jurusanList = [
            'Teknik Informatika',
            'Sistem Informasi',
            'Sains Data',
            'Teknik Komputer',
            'Rekayasa Perangkat Lunak',
        ];

        $statusList = ['Aktif', 'Aktif', 'Aktif', 'Aktif', 'Cuti', 'Lulus'];

        for ($i = 1; $i <= 40; $i++) {
            $angkatan = $faker->randomElement([2021, 2022, 2023, 2024]);
            $yearSuffix = substr((string) $angkatan, -2);
            $nrp = sprintf('5025%02d%04d', (int) $yearSuffix, $i + 1000);
            $nama = $faker->name();

            Mahasiswa::firstOrCreate(
                ['nrp' => $nrp],
                [
                    'nama' => $nama,
                    'email' => strtolower(str_replace(' ', '.', preg_replace('/[^a-zA-Z0-9\s]/', '', $nama))).rand(10, 99).'@student.its.ac.id',
                    'jurusan' => $faker->randomElement($jurusanList),
                    'angkatan' => $angkatan,
                    'ipk' => $faker->randomFloat(2, 3.10, 4.00),
                    'status' => $faker->randomElement($statusList),
                ]
            );
        }

        // 3. Data Mata Kuliah
        $mataKuliahs = [
            ['kode' => 'IF234401', 'nama_mk' => 'Pemrograman Berbasis Kerangka Kerja', 'sks' => 3, 'semester' => 6, 'dosen_pengampu' => 'Dr. Radityo Anggoro, S.Kom., M.Sc.'],
            ['kode' => 'IF234502', 'nama_mk' => 'Kecerdasan Buatan & Agentik', 'sks' => 3, 'semester' => 5, 'dosen_pengampu' => 'Prof. Ir. Supeno Djanali, M.Sc., Ph.D.'],
            ['kode' => 'IF234303', 'nama_mk' => 'Rekayasa Perangkat Lunak', 'sks' => 4, 'semester' => 4, 'dosen_pengampu' => 'Rizky Januar Akbar, S.Kom., M.Eng.'],
            ['kode' => 'IF234204', 'nama_mk' => 'Desain Basis Data Relasional', 'sks' => 3, 'semester' => 3, 'dosen_pengampu' => 'Dwi Sunaryono, S.Kom., M.Kom.'],
            ['kode' => 'IF234405', 'nama_mk' => 'Jaringan Komputer & Komunikasi Data', 'sks' => 3, 'semester' => 4, 'dosen_pengampu' => 'Royyana Muslim Ijtihadie, S.Kom., M.Kom., Ph.D.'],
            ['kode' => 'IF234106', 'nama_mk' => 'Struktur Data & Algoritma Tingkat Lanjut', 'sks' => 4, 'semester' => 2, 'dosen_pengampu' => 'Fajar Baskoro, S.Kom., M.T.'],
            ['kode' => 'IF234207', 'nama_mk' => 'Pemrograman Berorientasi Objek', 'sks' => 3, 'semester' => 3, 'dosen_pengampu' => 'Sarwosri, S.Kom., M.T.'],
            ['kode' => 'IF234608', 'nama_mk' => 'Keamanan Siber & Kriptografi Terapan', 'sks' => 3, 'semester' => 6, 'dosen_pengampu' => 'Hudan Studiawan, S.Kom., M.Kom., Ph.D.'],
            ['kode' => 'IF234609', 'nama_mk' => 'Cloud Computing & DevOps Modern', 'sks' => 3, 'semester' => 6, 'dosen_pengampu' => 'Bagus Jati Santoso, S.Kom., Ph.D.'],
            ['kode' => 'IF234510', 'nama_mk' => 'Pembelajaran Mesin & Analitik Data', 'sks' => 3, 'semester' => 5, 'dosen_pengampu' => 'Chastine Fatichah, S.Kom., M.Kom.'],
        ];

        foreach ($mataKuliahs as $mk) {
            MataKuliah::firstOrCreate(['kode' => $mk['kode']], $mk);
        }

        // 4. Data Ide Agentic AI Realistis
        $ideList = [
            [
                'nama' => 'Isabella Sienna Sulisthio',
                'judul_ide' => 'Agentic AI: Smart Prompt Optimizer & Token Budgeting',
                'deskripsi' => 'Agen cerdas terautomasi untuk menganalisis efisiensi prompt pengguna, memproyeksikan konsumsi token per sesi, serta merekomendasikan LLM yang paling hemat biaya tanpa mengurangi akurasi.',
                'status' => 'Disetujui',
            ],
            [
                'nama' => 'Ahmad Fadhil Prasetya',
                'judul_ide' => 'Automated Academic Schedule Conflict Resolver',
                'deskripsi' => 'Agen otonom yang memetakan preferensi jadwal mahasiswa, ketersediaan ruangan dosen, dan kapasitas kelas untuk menyelesaikan tabrakan jadwal FRS secara otomatis.',
                'status' => 'Disetujui',
            ],
            [
                'nama' => 'Nabila Putri Cahyani',
                'judul_ide' => 'Intelligent Research Paper Synthesizer & Citation Mapper',
                'deskripsi' => 'Agen asisten penelusuran pustaka yang dapat membaca puluhan PDF jurnal ilmiah, menyusun matriks literatur komparatif, dan mendeteksi kebaruan topik riset.',
                'status' => 'Menunggu Review',
            ],
            [
                'nama' => 'Bima Arya Pratama',
                'judul_ide' => 'AI Coding Tutor: Code Review & Anti-Plagiarism Advisor',
                'deskripsi' => 'Agen interaktif yang meninjau kode mahasiswa di lab pemrograman, memberikan saran refactoring standar PSR-12, dan mengecek kesamaan struktur algoritma.',
                'status' => 'Menunggu Review',
            ],
            [
                'nama' => 'Dewi Anggraini',
                'judul_ide' => 'Campus Mental Wellness & Workload Balancer Agent',
                'deskripsi' => 'Agen pendamping mahasiswa yang melacak beban tugas perkuliahan harian dan memberikan pengingat istirahat serta saran manajemen waktu cerdas.',
                'status' => 'Menunggu Review',
            ],
            [
                'nama' => 'Reza Kurniawan',
                'judul_ide' => 'Smart Laboratory Equipment Tracker & Auto-Booking',
                'deskripsi' => 'Sistem agen untuk peminjaman alat laboratorium hardware mikrokontroler berbasis IoT dengan integrasi verifikasi identitas mahasiswa.',
                'status' => 'Ditolak',
            ],
        ];

        foreach ($ideList as $ide) {
            IdeAgent::firstOrCreate(['judul_ide' => $ide['judul_ide']], $ide);
        }
    }
}
