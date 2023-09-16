<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    const UPDATED_AT = 'modified_at';
    public $fillable = [
        'name',
        'description',
        'price',
        'url_image_principal',
        'sub_category_id',
        'quantity',
        'status',
        'stock_min',
        'pasive',
        'created_by',
        'created_at',
        'modified_by',
        'modified_at',
    ];

    //relacion muchos a muchos
    public function colors()
    {
        return $this->belongsToMany(Color::class, 'color_products', 'product_id', 'color_id')
            ->withPivot('quantity', 'pasive', 'created_by', 'modified_by', 'stock_min', 'id')
            ->withTimestamps();
    }

    public function orders()
    {
        return $this->belongsToMany(Order::class, 'order_details', 'id_product', 'id_order')
            ->withPivot('quantity', 'price', 'discount', 'total', 'id_color_product', 'id_color_size');
    }

    // relacion uno a muchos
    public function sizes()
    {
        return $this->hasMany(Size::class);
    }

    // relacion uno a muchos inversa
    public function subCategory()
    {
        return $this->belongsTo(SubCategory::class);
    }
}
