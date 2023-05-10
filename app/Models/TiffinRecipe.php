<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TiffinRecipe extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'image', 'price', 'description', 'user_id'];

    protected $table = 'tiffinrecipes';


    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
