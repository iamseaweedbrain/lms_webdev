<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClassMember extends Model
{
    use HasFactory;

    protected $table = 'classmembers';
    protected $fillable = ['class_id', 'user_id', 'role', 'joined_at'];
    public $timestamps = false; // since you’re only using joined_at manually

    // Relationships
    public function user()
    {
        return $this->belongsTo(AccountModel::class, 'user_id', 'user_id');
    }

    public function class()
    {
        return $this->belongsTo(ClassModel::class, 'class_id', 'id');
    }
}

