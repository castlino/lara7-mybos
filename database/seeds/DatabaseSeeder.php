<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UserSeeder::class);
        DB::table('users')->insert([
            'name' => 'Lino Castro',
            'email' => 'castlino@gmail.com',
            'password' => Hash::make('lino'),
        ]);
        DB::table('users')->insert([
            'name' => 'mybos',
            'email' => 'mybos@mybos.com',
            'password' => Hash::make('mybos'),
        ]);
    }
}
