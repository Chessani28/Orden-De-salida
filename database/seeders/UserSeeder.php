<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
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
        User::create([
            'name' => 'Programacion',
            'email' => 'edgar@esydsa.com',
            'password' => Hash::make('123456'),
            'role_id' => '1',
        ]);
        User::create([
            'name' => 'Instalador',
            'email' => 'kike.eschess@gmail.com',
            'password' => Hash::make('12345678'),
            'role_id' => '2',
        ]);
        User::create([
            'name' => 'Vendedor',
            'email' => 'monitor@esydsa.com',
            'password' => Hash::make('12345678'),
            'role_id' => '3',
        ]);
        User::create([
            'name' => 'Verificacion',
            'email' => 'cesar_bm@max4technologies.com',
            'password' => Hash::make('12345678'),
            'role_id' => '4',
        ]);
        User::create([
            'name' => 'Programacion',
            'email' => 'sistemas2@max4technologies.com',
            'password' => Hash::make('12345678'),
            'role_id' => '1',
        ]);

    }
}
