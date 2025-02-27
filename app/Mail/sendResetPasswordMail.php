<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class sendResetPasswordMail extends Mailable
{
    use Queueable, SerializesModels;
    public $reset_password_link;
    /**
     * Create a new message instance.
     */
    public function __construct($reset_password_link)
    {
        $this->reset_password_link = $reset_password_link;
    }

    public function build()
    {
        return $this->subject("Reset Password Notification")->view('email.forgotpassword');
    }
}
