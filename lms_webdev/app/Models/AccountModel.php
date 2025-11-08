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
    public $incrementing = false;
    protected $fillable = ['firstname', 'lastname', 'email', 'password', 'avatar'];
    protected $hidden = ['password'];

    // Accessor for full name
    public function getNameAttribute()
    {
        return $this->firstname . ' ' . $this->lastname;
    }

    public function classesCreated()
    {
        return $this->hasMany(ClassModel::class, 'creator_id', 'user_id');
    }
    
    public function classMemberships()
    {
        return $this->hasMany(ClassMember::class, 'user_id', 'user_id');
    }
    public function pinnedClasses()
    {
        return $this->belongsToMany(ClassModel::class, 'pinned_classes', 'user_id', 'code');
    }
}
