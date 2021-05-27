<?php

namespace App\Imports;

use App\User;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\SkipsErrors;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class UsersImport implements ToModel, WithHeadingRow, SkipsOnError, WithValidation
{
    use Importable, SkipsErrors;
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */


    public function model(array $row)
    {
        return new User(["name" => $row['nama_member'],
            "member_id" => $row['id_kta'],
            "nik" => $row['id_ktp'],
            "phone" => $row['phone'],
            "level" => 'user',
        ]);
    }
    public function rules(): array
    {
        return [
            'id_kta' => ['required', 'unique:users,member_id'],
        ];
    }
}