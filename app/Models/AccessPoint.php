<?php

namespace App\Models;
use App\Models\Tower;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AccessPoint extends Model
{
    use HasFactory;

    public function tower(){
        return $this->belongsTo(tower::class);
    }

}
