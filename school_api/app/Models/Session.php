<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Session extends Model
{
    use HasFactory;
    protected $guarded=[];
    protected $hidden=['created_at','update_at'];
    public function assessment(){
        return $this->hasMany(Assessment::class,'session_id','id');
    }
}
