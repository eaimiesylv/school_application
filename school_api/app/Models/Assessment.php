<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Assessment extends Model
{
    use HasFactory;
    protected $hidden=['created_at','update_at'];
    protected $guarded=[];
}
