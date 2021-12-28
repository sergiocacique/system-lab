<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Role::firstOrCreate(['name' => 'administrador', 'guard_name' => 'web']);
        Role::firstOrCreate(['name' => 'aluno', 'guard_name' => 'web']);
    }
}
