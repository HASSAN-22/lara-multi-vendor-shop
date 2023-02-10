<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderUser extends Model
{
    use HasFactory;

    protected $table = 'order_users';

    protected $fillable = [
        'order_id',
        'user_id',
        'price',
        'full_amount',
        'title',
        'count',
        'property',
        'product_discount',
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function order(){
        return $this->belongsTo(Order::class);
    }
}
