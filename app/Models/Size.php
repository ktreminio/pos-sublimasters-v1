<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Size extends Model
{
    use HasFactory;
    const UPDATED_AT = 'modified_at';
    public $fillable = [
        'name',
        'pasive',
        'product_id',
        'created_by',
        'created_at',
        'modified_by',
        'modified_at',
    ];

    //relacion muchos a muchos
    public function colors()
    {
        return $this->belongsToMany(Color::class, 'color_sizes')
            ->withPivot('quantity', 'pasive', 'created_by', 'modified_by', 'stock_min', 'id')
            ->withTimestamps();
    }

    // relacion uno a muchos inversa
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
