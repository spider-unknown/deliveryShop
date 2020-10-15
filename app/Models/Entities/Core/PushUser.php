<?php

namespace App\Models\Entities\Core;

use Illuminate\Database\Eloquent\Model;

class PushUser extends Model
{
    protected $fillable = ['user_id', 'platform', 'push_id'];
}
