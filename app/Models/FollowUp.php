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

    public function getEstateIndicator(){
        return $this->hasMany(EstateIndicator::class, 'estate_id', 'estate_id');
    }

    public function getEstateIndicatorClose(){
        return $this->hasMany(EstateIndicatorSave::class, 'estate_id', 'estate_id');
    }

    public function getIndicatorMoney(){
        return $this->hasMany(IndicatorMoney::class, 'estate_id', 'estate_id');
    }

    public function getIndicatorMoneyClose(){
        return $this->hasMany(IndicatorMoneySave::class, 'estate_id', 'estate_id');
    }
}
