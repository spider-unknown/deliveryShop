<?php

namespace App\Models\Entities;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    public const IMAGE_DIRECTORY = "images/products";
    protected $fillable = ['name', 'description', 'price', 'category_id', 'image_path'];
}
