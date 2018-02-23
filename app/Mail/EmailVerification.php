<?php

namespace App\Mail;

use App\Models\EmailVerify;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class EmailVerification extends Mailable
{
    use Queueable, SerializesModels;

    public $verify;

    /**
     * EmailVerification constructor.
     * @param EmailVerify $verify
     */
    public function __construct(EmailVerify $verify)
    {
        $this->verify = $verify;
        $this->subject('【' . getSetting('site_title') . '】账号注册邮箱确认！');
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.verify');
    }
}
