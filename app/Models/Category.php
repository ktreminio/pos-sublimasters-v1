<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    const UPDATED_AT = 'modified_at';
    public $fillable = [
        'name',
        'icon',
        'slug',
        'url_image',
        'pasive',
        'created_by',
        'created_at',
        'modified_by',
        'modified_at',
    ];

    // Relacion uno a muchos
    public function subCategories()
    {
        return $this->hasMany(SubCategory::class);
    }
}
