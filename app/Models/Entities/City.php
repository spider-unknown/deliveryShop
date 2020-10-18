<?php

namespace App\Models\Entities;

use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    protected $fillable = ['name', 'country_id'];

    public function country() {
        return $this->belongsTo(Country::class, 'country_id', 'id');
    }

}
