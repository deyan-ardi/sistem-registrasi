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
            'nik' => '5100000000000000',
            'name' => 'I Gede Riyan Ardi D',
            'member_id' => '0000000000',
            'phone' => '081915656865',
            'level' => 'admin',
        ]);
    }
}