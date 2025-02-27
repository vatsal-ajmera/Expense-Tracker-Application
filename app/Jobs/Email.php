<?php

namespace App\Jobs;

use App\Helpers\Mail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class Email implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public $email_to;
    public $content;
    public function __construct($email_to,$content)
    {
        $this->email_to = $email_to;
        $this->content = $content;
    }

    /**
     * Execute the job.
     */
    public function handle()
    {
        $mail = new Mail();
        $mail->setRecipients($this->email_to)->setContent($this->content)->send();
    }
}
