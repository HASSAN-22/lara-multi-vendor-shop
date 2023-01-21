<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'brand_name',
        'brand_logo',
        'brand_website',
        'status'
    ];

    public function scopeSearch($query){
        $search = trim(request()->search);
        if($search != ''){
            $user = auth()->user();
            $query = $user->isAdmin() ? $query : $query->wher('user_id',$user->id);
            $query = $query->where('brand_name','like',"%$search%")->orWhere('brand_website','like',"%$search")
                ->orWhere('status',$search)->orWhereRelation('user','name',$search);
        }
        return $query;
    }

    public function user(){
        return $this->belongsTo(User::class);
    }
}
