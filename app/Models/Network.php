<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Network extends Model
{
    use HasFactory;
    protected $table = 'networks';

    public function maestro(){
        return $this->belongsTo(Maestro::class);
    }
    public function towers(){
        return $this->hasMany(Tower::class);
    }

}
