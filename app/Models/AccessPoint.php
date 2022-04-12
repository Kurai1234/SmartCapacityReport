<?php

namespace App\Models;
use App\Models\Tower;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\AccessPointStatistic;
class AccessPoint extends Model
{
    use HasFactory;

    protected $fillable=[
        'name',
        'mac_address',
        'product',
        'tower_id',
        'type',
        'ip_address',
        'tag'
    ];

    public function tower(){
        return $this->belongsTo(Tower::class);
    }
    public function accesspointstatistics(){
        return $this->hasMany(AccessPointStatistic::class);
    }
}
