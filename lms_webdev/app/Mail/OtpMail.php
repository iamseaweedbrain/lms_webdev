<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class OtpMail extends Mailable
{
    use Queueable, SerializesModels;

    public $otp;
    public $ttl;

    public function __construct($otp, $ttl)
    {
        $this->otp = $otp;
        $this->ttl = $ttl;
    }

    public function build()
    {
        return $this->subject('Your password reset code')
                    ->view('emails.otp')
                    ->with(['otp' => $this->otp, 'ttl' => $this->ttl]);
    }
}
