<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Subject extends Model
{
    use HasFactory;
    protected $guarded=[];
    public function klass(){
        return $this->belongsTo(Klass::class,'class_id','id')->select('id','class_name');
    }
    
}
