<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubCategory extends Model
{
    use HasFactory;
    const UPDATED_AT = 'modified_at';

    public $fillable = [
        'name',
        'slug',
        'url_image',
        'size',
        'color',
        'category_id',
        'pasive',
        'created_by',
        'created_at',
        'modified_by',
        'modified_at',
    ];

    // relacion uno a muchos inversa
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    // relacion uno a muchos
    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
