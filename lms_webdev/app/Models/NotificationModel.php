<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NotificationModel extends Model
{
    use HasFactory;

    protected $table = 'notifications';
    protected $primaryKey = 'notif_id';
    public $timestamps = false;
    protected $fillable = [
        'user_id',
        'message',
        'is_read',
        'created_at',
    ];

    public function user()
    {
        return $this->belongsTo(AccountModel::class, 'user_id', 'user_id');
    }
}

