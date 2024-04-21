<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Estate extends Model
{
    use HasFactory;

    public function getAdviser(){
        return $this->belongsTo(User::class,'adviser_id');
    }
}
