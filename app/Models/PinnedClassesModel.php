<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PinnedClassesModel extends Model
{
    use HasFactory;
    protected $table = 'pinned_classes';
    protected $fillable = ['user_id', 'code'];

    public function class()
    {
        return $this->belongsTo(ClassModel::class, 'code', 'code');
    }

    public function user()
    {
        return $this->belongsTo(AccountModel::class, 'user_id', 'user_id');
    }
}
