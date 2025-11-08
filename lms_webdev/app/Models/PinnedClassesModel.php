<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PinnedClassesModel extends Model
{
    use HasFactory;
    protected $table = 'useraccount';
    protected $fillable = ["user_id","code"];

    public function class()
    {
        return $this->belongsTo(ClassModel::class, 'class_id', 'id');
    }

    public function creator()
    {
        return $this->class->creator();
    }

}
