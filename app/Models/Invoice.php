<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'invoice_date',
        'total',
    ];

    public function products()
    {
        return $this->belongsToMany(Product::class, 'invoice_products');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function invoice_products()
    {
        return $this->hasMany(InvoiceProduct::class);
    }

    public function getTotalPriceAttribute()
    {
        $total = 0;
        foreach ($this->products as $product) {
            $total += $product->price * $product->pivot->quantity;
        }
        return $total;
    }

    public function getTotalQuantityAttribute()
    {
        $total = 0;
        foreach ($this->products as $product) {
            $total += $product->pivot->quantity;
        }
        return $total;
    }

    public function getInvoiceNumberAttribute()
    {
        return 'INV-' . $this->id;
    }

    public function getInvoiceDateAttribute()
    {
        return $this->created_at->format('d/m/Y');
    }

}
