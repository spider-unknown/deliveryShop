<?php

namespace App\Models\Entities;

use Illuminate\Database\Eloquent\Model;

class Favorite extends Model
{
    protected $fillable = ['product_id', 'user_id'];
}
