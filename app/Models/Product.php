<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'category'
    ];

    public function categories()
    {
        // many to many relationship through product_category table
        return $this->belongsToMany(Category::class, 'product_category');
        
    }
}
