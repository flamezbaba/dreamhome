<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class WordMail extends Mailable
{
    use Queueable, SerializesModels;

    public $subject;
    public $type;
    public $data;
    public $user;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($type, $subject, $user = null, $data = null)
    {
        $this->subject = $subject;
        $this->type = $type;
        $this->user = $user;
        $this->data = $data;
    }

    /**
     * Build the message.
     *
     * @return $thiss
     */
    public function build()
    {
        switch ($this->type) {
            case 'forgot_password':
                return $this->subject($this->subject)->view('emails.forgot');
                break;
            case 'register':
                    return $this->subject($this->subject)->view('emails.register');
                    break;
            case 'word':
                return $this->subject($this->subject)->view('emails.word');
                break;
            default:
                return $this->subject($this->subject)->view('emails.word');
                break;
        }
    }
}
