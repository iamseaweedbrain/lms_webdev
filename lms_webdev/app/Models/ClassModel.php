<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClassModel extends Model
{
    use HasFactory;

    protected $table = 'classes';
    protected $fillable = ['creator_id', 'classname', 'description', 'code', 'color'];

    // Relationships
    public function creator()
    {
        return $this->belongsTo(AccountModel::class, 'creator_id', 'user_id');
    }

    public function members()
    {
        return $this->hasMany(ClassMember::class, 'class_id', 'id');
    }
}

