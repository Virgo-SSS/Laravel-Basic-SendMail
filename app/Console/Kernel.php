<?php

namespace App\Console;

use Carbon\Carbon;
use App\Models\User;
use App\Jobs\SendEmailJob;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{

   
    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // $tanggal= User::where('created_at', Carbon::now())->get();
        
        $users = User::where('status_promo_email', '=', '1')->get();
        foreach($users as $user){
            $job = (new SendEmailJob($user->email,$user->id,$user->id))->onQueue('promo');
            $schedule->job($job)->everyMinute();
        }
        
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
