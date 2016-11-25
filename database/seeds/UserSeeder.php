<?php

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
        DB::table('users')->insert([
            'name' => 'superuser',
            'email' => 'no-reply@example.com',
            'password' => bcrypt('password'),
        ]);
    }
}
