<?php

namespace App\Mail;

use App\Models\config;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class TestingMail extends Mailable
{
    use Queueable, SerializesModels;
    public $email;
    public $id;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($userID, $link)
    {   
        $message = config::where('name', 'msg')->value('value');
        $this->id = $userID;
        $message = str_replace('[link]', $link, $message);
        $this->email = $message;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('email.send')
            ->subject('Verifikasi Email');
    }
}
