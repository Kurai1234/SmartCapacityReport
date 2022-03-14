<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Maestro extends Model
{
    use HasFactory;
    protected $fillable=[
        'name',
        'url'
    ];
    

    public function networks(){
        return $this->hasMany(Network::class);
    }


}
