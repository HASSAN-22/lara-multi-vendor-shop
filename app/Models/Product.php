<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'category_id',
        'brand_id',
        'guarantee_id',
        'title',
        'price',
        'discount',
        'count',
        'short_description',
        'description',
        'meta_keyword',
        'meta_description',
        'status',
        'is_original',
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function category(){
        return $this->belongsTo(Category::class);
    }

    public function brand(){
        return $this->belongsTo(Brand::class);
    }

    public function guarantee(){
        return $this->belongsTo(Guarantee::class);
    }

    public function productImages(){
        return $this->hasMany(ProductImage::class);
    }

    public function productProperties(){
        return $this->hasMany(ProductProperty::class);
    }

    public function productSpecification(){
        return $this->hasMany(ProductSpecification::class);
    }
}
