<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;


class Role extends Model
{
    use HasFactory;

    public static function getAllRole()
    {
        return Cache::rememberForever('role', function () {
            return self::all();
        });
    }
}
