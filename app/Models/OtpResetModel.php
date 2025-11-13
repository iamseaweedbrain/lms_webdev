<?php 

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OtpResetModel extends Model
{
    protected $table = 'otp_resets';
    protected $fillable = ['email','otp_hash','expires_at','attempts'];
    protected $dates = ['expires_at','created_at','updated_at'];
    public $timestamps = true;
}
