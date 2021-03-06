<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\UserDetail;
use App\Events\UserSaved;

class User extends Authenticatable
{
    use HasFactory, Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'prefixname',
        'firstname',
        'middlename',
        'lastname',
        'suffixname',
        'username',
        'photo',
        'type',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected $dispatchesEvents = [
        'saved' => UserSaved::class,
    ];


    public static function boot() {

        parent::boot();

        static::deleting(function($user) {
             $user->details()->delete();
        });
    }


    public function details()
    {
        return $this->hasMany(UserDetail::class, 'user_id');
    }


    public function getAvatarAttribute(): string
    {
        return "{$this->photo}";
    }

    public function getFullNameAttribute(): string
    {
         return "{$this->firstname} {$this->middlename}. {$this->lastname}";
    }

    public function getMiddleInitialAttribute(): string 
    {
        return "{$this->middlename}.";  
    } 
}
