<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FollowUp extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function getEstate(){
        return $this->estate_id;
        return EstateIndicator::where('estate_id', $this->estate_id )->get();
    }
}
