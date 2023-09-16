<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    const UPDATED_AT = 'modified_at';
    protected $fillable = [
        'payment_method',
        'deadline',
        'total',
        'discount',
        'status',
        'created_by',
        'modified_by',
        'pasive',
        'description',
        'payment_status',
    ];

    // Relacion muchos a muchos
    public function products()
    {
        return $this->belongsToMany(Product::class, 'order_details', 'id_order', 'id_product')
            ->withPivot('quantity', 'price', 'discount', 'total', 'id_color_product', 'id_color_size');
    }

    // Relacion uno a muchos
    public function cashTransactions()
    {
        return $this->hasMany(CashTransaction::class);
    }
}
