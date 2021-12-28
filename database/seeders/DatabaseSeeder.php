<?php

namespace Database\Seeders;

use App\Models\Aluno;
use App\Models\Aula;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(RoleSeeder::class);

        User::factory()->create()->each(function ($user) {
            $user->assignRole('aluno');
        });

        User::create([
            'name' => 'Danilo',
            'email' => 'danilovsdanilo@gmail.com',
            'password' => Hash::make('danilo123'),
        ])->assignRole('administrador');

        DB::transaction(function () {
            Aula::factory(10)->create()->each(function ($aula) {
                Aluno::factory()->count($aula->seat_limit)->create()->each(function ($aluno) use ($aula) {
                    $aula->alunos()->attach($aluno->id, ['checkin' => (bool) rand(0, 1)]);
                });
            });
        });
    }
}
