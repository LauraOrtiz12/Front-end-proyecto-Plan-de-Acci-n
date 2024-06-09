<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EstateIndicatorSave extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function getIndicator()
    {
        return $this->belongsTo(Indicator::class, 'indicator_id');
    }

    public function getEstate()
    {
        return $this->hasOne(Estate::class, 'id','estate_id');
    }
}
