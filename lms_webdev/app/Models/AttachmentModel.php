<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AttachmentModel extends Model
{
    use HasFactory;

    protected $table = 'attachments';
    protected $primaryKey = 'attach_id';
    public $timestamps = false;
    protected $fillable = [
        'post_id',
        'file_type',
        'file_path',
        'uploaded_at',
    ];

    // Relationships
    public function post()
    {
        return $this->belongsTo(PostModel::class, 'post_id', 'post_id');
    }
}
