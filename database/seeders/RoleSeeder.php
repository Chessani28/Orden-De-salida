<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;


class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Role::create(['name' => 'programacion']);
        Role::create(['name' => 'instalador']);
        Role::create(['name' => 'vendedor']);
        Role::create(['name' => 'verificacion']);

    }
}
