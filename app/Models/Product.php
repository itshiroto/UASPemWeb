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
        'category',
        'price',
        'image'
    ];

    public function categories()
    {
        // many to many relationship through product_category table
        return $this->belongsToMany(Category::class, 'product_category');
        
    }

    public function invoices()
    {
        // many to many relationship through invoice_product table
        return $this->belongsToMany(Invoice::class, 'invoice_products');
        
    }
}
