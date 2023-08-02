<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MergeSubject extends Model
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
    public function subject(){
        return $this->belongsTo(Subject::class,'subject_id','id');
    }
    public function mergename(){
      return $this->belongsTo(Subject::class,'merge_name','id');
    }
    public function clas(){
        return $this->belongsTo(Klass::class,'class_id','id');
      }
}
