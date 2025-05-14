<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'image1',
        'image2',
        'name',
        'description',
        'color',
        'thickness',
        'size',
        'application',
        'woodtype',
        'corematerial',
        'price',
    ];


    public function sizes()
{
    return $this->hasMany(Size::class);
}

public function images()
{
    return $this->hasMany(Image::class);
}

}
