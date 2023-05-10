<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'image'];


    // The URL of the image can be generated like this:
    public function getImageUrlAttribute()
    {
        return asset('storage/' . $this->image);
    }
}
