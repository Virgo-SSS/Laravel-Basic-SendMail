<?php

namespace App\Jobs;

use App\Mail\TestingMail;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Mail;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Contracts\Queue\ShouldBeUnique;

class SendEmailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $email;
    protected $link;
    protected $userID;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($userEMAIL,$userID,$link)
    {
        $this->email = $userEMAIL;
        $this->userID = $userID;
        $this->link = $link;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $msg = new TestingMail($this->userID,$this->link);
        Mail::to($this->email)->send($msg);
    }
}
