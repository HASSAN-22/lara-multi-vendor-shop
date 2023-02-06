<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'email',
        'message',
        'commentable_type',
        'commentable_id',
    ];

    public function commentable(){
        $this->morphTo();
    }

    public function user(){
        return $this->belongsTo(User::class);
    }
}
