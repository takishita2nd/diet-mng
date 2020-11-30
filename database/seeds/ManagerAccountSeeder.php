<?php

use Illuminate\Database\Seeder;

class ManagerAccountSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert(['name' => 'manager', 'email' => 'manage@gmail.com', 'password' => bcrypt('manager')]);
    }
}
