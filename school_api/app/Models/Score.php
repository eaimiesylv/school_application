<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Score extends Model
{
    use HasFactory;
    protected $guarded=[];
    public static function boot()
    {
        parent::boot();

        static::creating(function ($user) {
            $classDetails = [
                'ip' => request()->getClientIp(),
                'created_by' => auth()->id(),
                
                
            ];

            $user->fill($classDetails);
        });
    }
}
