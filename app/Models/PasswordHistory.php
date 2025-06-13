<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use  App\Models\User;

class PasswordHistory extends Model
{
    use HasFactory;

    protected $fillable = [
        'password'
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }

}
