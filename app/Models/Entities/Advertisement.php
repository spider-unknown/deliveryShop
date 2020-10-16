<?php

namespace App\Models\Entities;

use Illuminate\Database\Eloquent\Model;

class Advertisement extends Model
{
    public const TOP = 1;
    public const MIDDLE = 2;

    public const IMAGE_DIRECTORY = "images/advertisements";

    protected $fillable = ['image_path', 'link', 'position', 'product_id'];

    public function product() {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }
}
