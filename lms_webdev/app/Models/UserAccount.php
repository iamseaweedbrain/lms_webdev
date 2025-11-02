<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class UserAccount extends Model
{
    use HasFactory;

    protected $table = 'useraccounts';
    protected $primaryKey = 'user_id';
    protected $fillable = ['name', 'email', 'password', 'avatar'];
}

