<?php

use App\User;
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
        User::create([
            'nik' => '5107012206870001',
            'name' => 'I Gede Riyan Ardi D',
            'member_id' => '1921581001',
            'level' => 'admin',
        ]);
    }
}