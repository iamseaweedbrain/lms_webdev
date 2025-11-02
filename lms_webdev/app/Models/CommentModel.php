<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CommentModel extends Model
{
    use HasFactory;

    protected $table = 'comments';
    protected $primaryKey = 'comment_id';
    public $timestamps = false; //manual lang sha
    protected $fillable = [
        'post_id',
        'user_id',
        'comment_text',
        'created_at',
    ];

    // Relationships
    public function post()
    {
        return $this->belongsTo(PostModel::class, 'post_id', 'post_id');
    }

    public function user()
    {
        return $this->belongsTo(UserAccount::class, 'user_id', 'userid');
    }
}

