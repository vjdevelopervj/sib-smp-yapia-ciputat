<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Person;
use Illuminate\Support\Str;

class PersonSeeder extends Seeder
{
    public function run(): void
    {
        $roles = [
            'Siswa' => ['L', 200],
            'Siswi' => ['P', 200],
            'Guru' => ['L', 30],
            'Staff' => ['P', 20],
            'Admin' => ['L', 5],
        ];

        $counter = 1;

        foreach ($roles as $role => [$gender, $jumlah]) {
            for ($i = 0; $i < $jumlah; $i++) {
                Person::create([
                    'kode_orang' => 'ORG' . str_pad($counter, 5, '0', STR_PAD_LEFT),
                    'nama' => fake()->name($gender === 'Laki-laki' ? 'male' : 'female'),
                    'jenis_kelamin' => $gender,
                    'role' => $role,
                    'kelas' => in_array($role, ['Siswa', 'Siswi']) ? 'Kelas ' . rand(7, 9) . chr(rand(65, 67)) : null,
                    'email' => fake()->unique()->safeEmail,
                    'telepon' => fake()->phoneNumber,
                    'catatan' => fake()->optional()->sentence(),
                ]);

                $counter++;
            }
        }
    }
}
