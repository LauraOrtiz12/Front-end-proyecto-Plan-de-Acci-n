<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdvisorOffices extends Model
{
    use HasFactory;

    public function getEstate()
    {
        return $this->hasOne(Estate::class, 'id','estate_id');
    }
}
