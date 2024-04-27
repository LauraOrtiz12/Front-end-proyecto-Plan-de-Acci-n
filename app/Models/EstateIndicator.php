<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EstateIndicator extends Model
{
    use HasFactory;

    public function getIndicator()
    {
        return $this->belongsTo(Indicator::class, 'indicator_id');
    }
}
