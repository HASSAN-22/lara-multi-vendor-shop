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

    public function scopeSearch($query){
        $search = trim(request()->search);
        if($search != ''){
            $search = str_replace([',','$'],'',$search);
            $user = auth()->user();
            $query = $user->isAdmin() ? $query : $query->where('user_id',$user->id);
            $query = $query->where(function($query)use($search){
                $query->orWhere('title','like',"%$search%")
                    ->orWhere('price',$search)
                    ->orWhere('status',$search)->orWhereRelation('user','name',$search)->orWhereRelation('category','title',$search);
            });
        }
        return $query;
    }

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

    public function image(){
        return $this->hasOne(ProductImage::class);
    }

    public function productImages(){
        return $this->hasMany(ProductImage::class);
    }

    public function productProperties(){
        return $this->hasMany(ProductProperty::class);
    }

    public function productSpecifications(){
        return $this->hasMany(ProductSpecification::class);
    }

    public function comments(){
        return $this->morphMany(Comment::class, 'commentable');
    }

    public function ratings(){
        return $this->hasMany(Rating::class);
    }
}
