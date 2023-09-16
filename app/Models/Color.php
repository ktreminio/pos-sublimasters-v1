<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Color extends Model
{
    use HasFactory;
    const UPDATED_AT = 'modified_at';

    public $fillable = [
        'name',
        'hex',
        'pasive',
        'created_by',
        'created_at',
        'modified_by',
        'modified_at'
    ];

    //relacion muchos a muchos
    public function products()
    {
        return $this->belongsToMany(Product::class, 'color_products', 'color_id', 'product_id')
            ->withPivot('quantity', 'pasive', 'created_by', 'modified_by', 'stock_min', 'id')
            ->withTimestamps();
    }

    public function sizes()
    {
        return $this->belongsToMany(Size::class, 'color_sizes')
            ->withPivot('quantity', 'pasive', 'created_by', 'modified_by', 'stock_min', 'id')
            ->withTimestamps();
    }
}
