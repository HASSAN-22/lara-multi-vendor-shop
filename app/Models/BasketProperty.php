<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BasketProperty extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $table = 'basket_properties';

    protected $fillable = ['basket_id','property_id'];

    public function basket(){
        return $this->belongsTo(Basket::class);
    }

    public function property(){
        return $this->belongsTo(Property::class);
    }
}
