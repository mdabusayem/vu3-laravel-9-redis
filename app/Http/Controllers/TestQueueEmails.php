<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Jobs\TestSendEmail;
use App\Mail\TestHelloEmail;
use Mail;

class TestQueueEmails extends Controller
{
    public function sendTestEmails()
    {
        $emailJobs = new TestSendEmail();
        if($this->dispatch($emailJobs))
        {
            dd('done');
        }
        else
        {
            dd('no');
        }
        //$email = new TestHelloEmail();
        //Mail::to('sayem.bauet@gmail.com')->send($email);
    }
}
