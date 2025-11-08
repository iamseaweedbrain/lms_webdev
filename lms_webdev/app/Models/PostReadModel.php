<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PostReadModel extends Model
{
    use HasFactory;

    protected $table = 'post_reads';
    protected $fillable = ['user_id', 'post_id', 'read_at'];
    public $timestamps = false;

    public function post()
    {
        return $this->belongsTo(PostModel::class, 'post_id', 'post_id');
    }

    public function user()
    {
        return $this->belongsTo(AccountModel::class, 'user_id', 'user_id');
    }
}
