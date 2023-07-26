<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubjectAllocation extends Model
{
    use HasFactory;
    protected $guarded=[];
    protected $hidden =['updated_at','created_at','ip'];
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
    public function clas(){
        return $this->belongsTo(Klass::class,'class_id','id')->select('id','class_name','class_value');
    }
    public function users(){
        return $this->belongsTo(User::class,'teacher_id','id')->select('id','first_name','last_name');
    }
    public function subjects(){
        return $this->belongsTo(Subject::class,'subject_id','id')->select('id','subjects');
    }
}
