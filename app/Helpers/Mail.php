<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail as Email;
use Illuminate\Mail\Mailable;

class Mail
{
    private $content;
    private $to;

    /**
     * @param array $to
     */
    public function setRecipients(array $to)
    {
        $this->to = $to;
        return $this;
    }

    /**
     * @param Mailable $content
     */
    public function setContent(Mailable $content)
    {
        $this->content = $content;
        return $this;
    }

    public function send()
    {
        try {
            Email::to($this->to)->send($this->content);
            return false;
        } catch (\Exception $ex) {
            $subject =
                $this->content instanceof Mailable
                    ? $this->content->subject ?? ''
                    : '';
            $log_msg =
                'Email sending failed, subject:' .
                $subject .
                ' to:' .
                json_encode($this->to) .
                ' error:' .
                $ex->getMessage();
            Log::channel('emaillogs')->info($log_msg);

            return $ex->getMessage();
        }
    }
}
