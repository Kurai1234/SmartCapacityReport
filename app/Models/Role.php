<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
    ];

    public function scopeSuperAdmin($query)
    {
        return $query->where('name', 'Super Administrator')->value('id');
    }

    public function users()
    {
        return    $this->hasMany(User::class);
    }

    public function scopeAdminCreate($query)
    {
        return $query->where('id', '!=', 3)->get();
    }
    public function scopeSuperAdminCreate($query)
    {
        return $query->get();
    }
    public static function higherAuthority($test, $tobeTest)
    {
        return User::find($test)->role_id < User::find($tobeTest)->role_id ? true : false;
    }

    public function hasAuthority()
    {
        return $this->id == 1 ? false : true;
    }
}
