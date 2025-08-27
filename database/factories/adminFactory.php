<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;

class AdminFactory extends Factory
{

    /**
     * Default state untuk membuat user role siswa
     */
    public function definition(): array
    {
        return [
            'username' => $this->faker->unique()->userName(),
            'password' => Hash::make('123'), // password default biar gampang login
            'role'     => 'siswa',          // default role
        ];
    }

    /**
     * State khusus admin
     */
    public function dataadmin1()
    {
        return $this->state([
            'username' => 'admin',
            'password' => Hash::make('admin'),
            'role'     => 'admin',
        ]);
    }

    /**
     * State khusus guru
     */
    public function dataadmin2()
    {
        return $this->state([
            'username' => 'guru',
            'password' => Hash::make('guru'),
            'role'     => 'guru',
        ]);
    }
}
