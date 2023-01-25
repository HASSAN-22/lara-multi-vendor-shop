<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductProperty extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $table = 'product_properties';

    protected $fillable = [
        'product_id',
        'property_id',
        'name',
        'count',
        'price',
    ];

    public function product(){
        return $this->belongsTo(Product::class);
    }

    public function property(){
        return $this->belongsTo(Property::class);
    }
}
