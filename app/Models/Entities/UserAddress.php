<?php

namespace App\Models\Entities;

use Illuminate\Database\Eloquent\Model;

class UserAddress extends Model
{
    protected $fillable = ['user_id', 'city_id', 'address', 'main', 'comment'];

    public function city() {
        return $this->belongsTo(City::class, 'city_id', 'id');
    }
}
