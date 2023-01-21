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

    public function isAdmin(){
        return $this->access == 'admin';
    }

    public function isCustomer(){
        return $this->accsess == 'customer';
    }

    public function isVendor(){
        return $this->accsess == 'vendor';
    }

    public function loginHistories(){
        return $this->hasMany(LoginHistory::class);
    }

    public function brand(){
        return $this->hasOne(Brand::class);
    }
}
