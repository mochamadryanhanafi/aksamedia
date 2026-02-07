<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class NilaiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create('id_ID');

        // Clear existing data to avoid duplicates if re-seeding
        // DB::table('nilai')->truncate(); // Optional: user might want to keep existing data? Safest to just add.

        $students = [];
        for ($i = 0; $i < 50; $i++) {
            $students[] = [
                'nama' => $faker->name,
                'nisn' => $faker->unique()->numerify('##########'),
                'jk' => $faker->randomElement(['L', 'P']),
                'nama_sekolah' => 'SMA ISLAM UBUDIYAH MANTANGAI'
            ];
        }

        foreach ($students as $student) {
            // Seed RT (Materi Uji ID: 7)
            $rtSubjects = [
                ['id' => 36, 'name' => 'REALISTIC'],
                ['id' => 38, 'name' => 'INVESTIGATIVE'],
                ['id' => 39, 'name' => 'ARTISTIC'],
                ['id' => 40, 'name' => 'SOCIAL'],
                ['id' => 41, 'name' => 'ENTERPRISING'],
                ['id' => 42, 'name' => 'CONVENTIONAL'],
            ];

            foreach ($rtSubjects as $subject) {
                DB::table('nilai')->insert([
                    'id_status' => $faker->randomNumber(7),
                    'profil_tes_id' => 31,
                    'id_siswa' => $faker->randomNumber(6),
                    'nama' => $student['nama'],
                    'nisn' => $student['nisn'],
                    'jk' => $student['jk'],
                    'skor' => $faker->numberBetween(1, 10),
                    'nama_pelajaran' => $subject['name'],
                    'pelajaran_id' => $subject['id'],
                    'materi_uji_id' => 7, // RT
                    'nama_sekolah' => $student['nama_sekolah'],
                    'total_soal' => 7,
                ]);
            }

            // Seed ST (Materi Uji ID: 4)
            $stSubjects = [
                ['id' => 44, 'name' => 'Verbal'],
                ['id' => 45, 'name' => 'Kuantitatif'],
                ['id' => 46, 'name' => 'Penalaran'],
                ['id' => 47, 'name' => 'Figural'],
            ];

            foreach ($stSubjects as $subject) {
                DB::table('nilai')->insert([
                    'id_status' => $faker->randomNumber(7),
                    'profil_tes_id' => 31,
                    'id_siswa' => $faker->randomNumber(6),
                    'nama' => $student['nama'],
                    'nisn' => $student['nisn'],
                    'jk' => $student['jk'],
                    'skor' => $faker->numberBetween(1, 20), // Raw score
                    'nama_pelajaran' => $subject['name'],
                    'pelajaran_id' => $subject['id'],
                    'materi_uji_id' => 4, // ST
                    'nama_sekolah' => $student['nama_sekolah'],
                    'total_soal' => 20,
                ]);
            }
        }
    }
}
