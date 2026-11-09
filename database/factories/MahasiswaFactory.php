<?php

namespace Database\Factories;

use App\Models\Mahasiswa;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Mahasiswa>
 */
class MahasiswaFactory extends Factory
{
    protected $model = Mahasiswa::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nrp' => fake()->unique()->numerify('502524####'),
            'nama' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'jurusan' => fake()->randomElement([
                'Teknik Informatika',
                'Sistem Informasi',
                'Sains Data',
                'Teknik Komputer',
                'Rekayasa Perangkat Lunak',
            ]),
            'angkatan' => fake()->numberBetween(2021, 2024),
            'ipk' => fake()->randomFloat(2, 3.00, 4.00),
            'status' => 'Aktif',
        ];
    }
}
