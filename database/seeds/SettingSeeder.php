<?php

use App\Setting;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Setting::create([
            'type_email' => 'gmail.com',
            'name_system' => 'Sistem Manajemen Komunitas',
            'name_comunity' => 'Komunitas Wirausaha Muda Denpasar',
        ]);
    }
}