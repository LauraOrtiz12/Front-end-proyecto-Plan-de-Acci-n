<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Estate extends Model
{
    use HasFactory;
    protected $guarded= [];

    public function getResponsible(){
        return $this->belongsTo(User::class,'responsible_id');
    }
    public function getAdviser(){
        return $this->belongsTo(User::class,'adviser_id');
    }
}
