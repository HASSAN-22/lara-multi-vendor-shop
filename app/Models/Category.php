<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'parent_id',
        'title',
        'slug',
        'status',
        'meta_description',
        'meta_keyword',
    ];


    public function scopeSearch($query){
        $search = trim(request()->search);
        if($search != ''){
            $query = $query->where('title','like',"%$search%")->orWhere('status',$search)->orWhereRelation('category','title',$search);
        }
        return $query;
    }

    public function category(){
        return $this->belongsTo(Category::class,'parent_id','id');
    }

    public function childes(){
        return $this->hasMany(Category::class, 'parent_id','id')->with('category');
    }
}
