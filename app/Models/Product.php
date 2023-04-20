<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $fillable = [
        'category_id',
        'name',
        'slug',
        'description',
        'image',
    ];

    public function getImageUrlAttribute()
    {
        if(!empty($this->image)){
            return asset('storage/products/'.$this->image);
        }
        return asset('product.png');
    }

    public function scopeCategoryId($query,$category_id)
    {
        return $query->where('category_id',$category_id);
    }

    public function variants()
    {
        return $this->hasMany(ProductVariant::class, 'product_id');
    }
    
}
