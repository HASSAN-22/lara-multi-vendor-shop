<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'limit_user',
        'discount',
        'expire_at',
    ];

    public function scopeSearch($query){
        $search = trim(request()->search);
        if($search != ''){
            $query = $query->where('code','like',"%$search%")->orWhere('discount',$search)->orWhere('expire_at',$search);
        }
        return $query;
    }

    public function belongsToManyCouponProducts(){
        return $this->belongsToMany(Coupon::class,'coupon_products','coupon_id','product_id');
    }

    public function couponProducts(){
        return $this->hasMany(CouponProduct::class);
    }

    public function couponUsers(){
        return $this->hasMany(CouponUser::class);
    }
}
