<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PostModel extends Model
{
    use HasFactory;

    protected $table = 'posts';
    protected $primaryKey = 'post_id';
    public $timestamps = false; // since we’re manually using created_at
    protected $fillable = [
        'class_id',
        'user_id',
        'avatar',
        'post_type',
        'content',
        'due_date',
        'max_score',
        'created_at'
    ];

    public function class()
    {
        return $this->belongsTo(ClassModel::class, 'class_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo(AccountModel::class, 'user_id', 'user_id');
    }
}

