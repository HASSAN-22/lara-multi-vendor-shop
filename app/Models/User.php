<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'access',
        'status',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function scopeSearch($query){
        $search = trim(request()->search);
        if($search != ''){
            $query = $query->where('name','like',"%$search%")->orWhere('email','like',"%$search%")->orWhere('status',$search)->orWhere('access',$search);
        }
        return $query;
    }

    /**
     * @return mixed
     */
    public function shopName(){
        return $this->profile->shop_name ?? 'N/A';
    }

    public function avatar(){
        return $this->profile->avatar ?? '/user.png';
    }

    public function isAdmin(){
        return $this->access == 'admin';
    }

    public function isCustomer(){
        return $this->access == 'customer';
    }

    public function isVendor(){
        return $this->access == 'vendor';
    }

    public function loginHistories(){
        return $this->hasMany(LoginHistory::class);
    }

    public function brand(){
        return $this->hasOne(Brand::class);
    }

    public function products(){
        return $this->hasMany(Product::class);
    }

    public function profile(){
        return $this->hasOne(Profile::class);
    }

    public function wishlists(){
        return $this->hasMany(Wishlist::class);
    }

    public function baskets(){
        return $this->hasMany(Basket::class);
    }

    public function ratings(){
        return $this->hasMany(Rating::class);
    }

    public function couponUsers(){
        return $this->hasMany(CouponUser::class);
    }
}
