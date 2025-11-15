<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Mail;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Mail\OverLimitMail;
use App\Models\Unit;
use App\Models\DailyTotalizer;
use App\Models\User;

class SendOverLimitReportJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $overLimitData;
   

    public function __construct($overLimitData)
    {
        $this->overLimitData = $overLimitData;
    }

    public function handle()
    {

      $userEmail = "jatsureshkumar47@gmail.com";
      
        Mail::to($userEmail)
            ->send(new OverLimitMail( $this->overLimitData));
    }
}
