<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::create([
            'name' => 'Alejandro',
            'email' => 'alejandro@alenka.com',
            'username' => 'Administradors',
            'id' => '1',
            'empresa_id' => '1',
            'password' => bcrypt('password'),
        ]);
        $user->assignRole('Administrador');
    }
}
