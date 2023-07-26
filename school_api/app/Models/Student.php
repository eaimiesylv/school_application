<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;
    protected $guarded=[];
    protected $hidden=['updated_at','created_at','id'];
    public function sessions(){

        return $this->belongsTo(Session::class,'session_id','id');
    }
    public function user(){

        return $this->belongsTo(User::class,'user_id','id');
    }
}
