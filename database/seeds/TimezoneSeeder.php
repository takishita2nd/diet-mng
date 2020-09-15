<?php

use Illuminate\Database\Seeder;

class TimezoneSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('timezones')->insert(['zone' => '朝',]);
        DB::table('timezones')->insert(['zone' => '昼',]);
        DB::table('timezones')->insert(['zone' => '夜',]);
        DB::table('timezones')->insert(['zone' => '間食',]);
    }
}
