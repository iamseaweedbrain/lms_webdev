<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class AccountModel extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'useraccount';
    protected $primaryKey = 'user_id';
    public $incrementing = false; // since you're using uniqid()
    protected $fillable = ['firstname', 'lastname', 'email', 'password', 'avatar'];
    protected $hidden = ['password'];
}
