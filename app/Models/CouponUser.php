<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CouponUser extends Model
{
    use HasFactory;

    protected $table = 'coupon_users';

    public $timestamps = false;

    protected $fillable = ['user_id','coupon_id'];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function coupon(){
        return $this->belongsTo(Coupon::class);
    }
}
