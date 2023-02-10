<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'transaction',
        'payment',
        'status',
        'discount',
        'coupon_code'
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function orderUsers(){
        return $this->hasMany(OrderUser::class);
    }
}
