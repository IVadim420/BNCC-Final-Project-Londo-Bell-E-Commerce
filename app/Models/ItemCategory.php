<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ItemCategory extends Model
{
    use HasFactory;

    protected $fillable = ['category'];

    public function item()
    {
        return $this->hasMany(Item::class, 'category_id');
    }

}
