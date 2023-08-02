<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClassteacherAllocation extends Model
{
    use HasFactory;
    protected $guarded=[];
    public static function boot()
    {
        parent::boot();

        static::creating(function ($user) {
            $classDetails = [
             
                'created_by' => auth()->id(),
                
                
            ];

            $user->fill($classDetails);
        });
    }
    public function users(){
        return $this->belongsTo(User::class, 'teacher_id','id')->select('id','first_name','last_name');
    }
}
