<?php

namespace App\Exports;

use App\User;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;

class UsersExport implements FromQuery, WithHeadings
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function query()
    {
        return User::select('member_id', 'nik', 'email', 'name', 'phone')->where('email_verified_at', '!=', NULL);
    }
    public function headings(): array
    {
        return ['No KTA', 'No KTP', 'Email Member', 'Nama Member', 'Telepon'];
    }
}