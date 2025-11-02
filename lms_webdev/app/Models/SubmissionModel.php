<?php

namespace App\Models;

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubmissionModel extends Model
{
    use HasFactory;

    protected $table = 'submissions';
    protected $primaryKey = 'submission_id';
    public $timestamps = false;
    protected $fillable = [
        'post_id',
        'user_id',
        'file_type',
        'file_path',
        'submitted_at',
        'score',
        'feedback',
        'graded_by',
        'graded_at'
    ];

    // Relationships
    public function post()
    {
        return $this->belongsTo(PostModel::class, 'post_id', 'post_id');
    }

    public function student()
    {
        return $this->belongsTo(UserAccount::class, 'user_id', 'userid');
    }

    public function grader()
    {
        return $this->belongsTo(UserAccount::class, 'graded_by', 'userid');
    }
}

