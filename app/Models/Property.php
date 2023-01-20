<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Property extends Model
{
    use HasFactory;

    protected $fillable = ['property'];

    public function scopeSearch($query){
        $search = trim(request()->search);
        if($search != ''){
            $query = $query->where('property','like',"%$search");
        }
        return $query;
    }
}
