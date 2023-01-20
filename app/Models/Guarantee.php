<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Guarantee extends Model
{
    use HasFactory;

    protected $fillable = ['guarantee'];

    public function scopeSearch($query){
        $search = trim(request()->search);
        if($search != ''){
            $query = $query->where('guarantee','like',"%$search");
        }
        return $query;
    }
}
