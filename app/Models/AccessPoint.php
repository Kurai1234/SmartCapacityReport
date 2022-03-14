<?php

namespace App\Models;
use App\Models\Tower;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\AccessPointStatistic;
class AccessPoint extends Model
{
    use HasFactory;

    public function tower(){
        return $this->belongsTo(tower::class);
    }
    public function accesspointstatistics(){
        return $this->hasMany(AccessPointStatistic::class);
    }
}
