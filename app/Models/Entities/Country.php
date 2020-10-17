<?php

namespace App\Models\Entities;

use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    protected $fillable = ['name'];

    public function cities() {
        return $this->hasMany(City::class, 'country_id', 'id');
    }
}
