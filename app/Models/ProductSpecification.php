<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductSpecification extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $table = 'product_specifications';

    protected $fillable = [
        'product_id',
        'name',
        'description',
    ];

    public function product(){
        return $this->belongsTo(Product::class);
    }

}
