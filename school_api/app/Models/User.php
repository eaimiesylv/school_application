<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Str;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'email_regno',
        'password',
        'passport',
        'username',
        'class_id',
        'session_id',
        'dob',
        'sex',
        'role',
        'ip',
        'hash'
        
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'id',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];
    public static function boot(){
        parent::boot();
        static::creating(function($user){
            $userdetails=[
                'ip'=>request()->getClientIp(),
                'hash'=>Str::uuid()
            ];
            $user->fill($userdetails);
        });

    }
    public function scores()
    {
        return $this->hasMany(Score::class, 'user_id');
    }
}
