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
                'user_id' =>  request()->user_id,
                'unique_score'=> request()->user_id."t".request()->assessment_id."t".request()->subject_id."t".request()->class_id
                
                
            ];

            $user->fill($classDetails);
        });
    }
    public function term_session(){
        return $this->belongsTo(Session::class,'session_id','id')->select('id','year','term');
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function assessment(){
        return $this->belongsTo(Assessment::class,'assessment_id','id')->select('id','assessname');
    }
    public function subject()
    {
        return $this->belongsTo(Subject::class, 'subject_id');
    }

    
}
