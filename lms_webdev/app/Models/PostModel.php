<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PostModel extends Model
{
    use HasFactory;

    protected $table = 'posts';
    protected $primaryKey = 'post_id';
    public $timestamps = false; 
    protected $fillable = [
        'user_id',
        'code',
        'post_title',
        'post_type',
        'content',
        'color',
        'due_date',
        'file_path',
        'file_link',
    ];
    protected $appends = ['avatar'];

    public function getAvatarAttribute()
    {
        return $this->user->avatar ?? asset('images/default-avatar.png');
    }

    public function class()
    {
        return $this->belongsTo(ClassModel::class, 'class_id', 'code');
    }

    public function user()
    {
        return $this->belongsTo(AccountModel::class, 'user_id', 'user_id');
    }
}

