<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Klass extends Model
{
    use HasFactory;
    protected $guarded=[];
    public function user(){
        return $this->belongsTo(User::class,'created_by','id')
                    ->select('id','first_name','last_name');
    }
    
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
    public function subjects(){
        return $this->hasMany(Subject::class,'class_id','id')->select('id','class_id','subjects','subject_label');

    }
    public function getClassNameWithValueAttribute()
    {
        return $this->class_name . ' ' . $this->class_value;
    }
    public function subjectallocation(){
        return $this->hasMany(SubjectAllocation::class,'class_id','id');

    }
    public function mergesubject(){
        return $this->hasMany(MergeSubject::class,'class_id','id');

    }
    public function students(){
        return $this->hasMany(Student::class,'class_id','id');

    }

}
