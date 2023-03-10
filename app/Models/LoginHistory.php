<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LoginHistory extends Model
{
    use HasFactory;

    protected $table = 'login_histories';

    protected $fillable = ['user_id','login_at'];

    public $timestamps = false;

    public function user(){
        return $this->belongsTo(User::class);
    }
}
