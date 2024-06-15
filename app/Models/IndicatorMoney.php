<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IndicatorMoney extends Model
{
    use HasFactory;
    protected $guarded = [];

    protected $casts = [
        'id' => 'string'
    ];

    public function getProject(){
        return $this->belongsTo(Project::class, 'project_id', 'code');
    }

    public function getEstate()
    {
        return $this->hasOne(Estate::class, 'id','estate_id');
    }
}
