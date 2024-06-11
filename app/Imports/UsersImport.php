<?php

namespace App\Imports;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class UsersImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        //codigo	nombre	correo	telefono	clave
        return new User([
            'role_id' => $row['rol'],
            'code' => $row['codigo'],
            'name' => $row['nombre'],
            'email' => $row['correo'],
            'password' => bcrypt($row['clave']),
        ]);
    }
}
