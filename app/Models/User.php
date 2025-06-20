<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Infinitypaul\LaravelPasswordHistoryValidation\Traits\PasswordHistoryTrait;
use App\Models\PasswordHistory;
use App\Models\Post;

class User extends Authenticatable
{
    use HasFactory, Notifiable;
    use PasswordHistoryTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'username', 'email','password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    
    public function passwordHistories(){
        return $this->hasMany(PasswordHistory::class);
    }
    

}
