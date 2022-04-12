<?php

namespace App\Models;
use App\Models\Network;
use App\Models\AccessPoint;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use function PHPSTORM_META\map;

class Tower extends Model
{
    use HasFactory;

    protected $table='towers';
    protected $fillable=[
        'name',
        'network_id'
    ];

    public function network(){
        return $this->belongsTo(Network::class);
    }
    public function accesspoints(){
        return $this->hasMany(AccessPoint::class);
    }

}
