<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PinnedClassesModel extends Model
{
    use HasFactory;
    protected $table = 'useraccount';
    protected $fillable = ["user_id","code"];
}
