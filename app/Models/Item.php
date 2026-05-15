<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Item extends Model
{
    Use HasFactory;

    protected $fillable = ['name', 'description', 'stock', 'category_id', 'image', 'price'];

    public function category()
    {
        return $this->belongsTo(ItemCategory::class, 'category_id');
    }

}
