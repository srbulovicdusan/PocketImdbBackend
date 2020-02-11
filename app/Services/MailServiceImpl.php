<?php
namespace App\Services;

use Illuminate\Support\Facades\Mail;

class MailServiceImpl implements MailService{
    public function sendEmailToAdmins($text){
        Mail::raw($text,function ($message) {        
            $message->to(env('ADMIN_EMAIL'));
        });
    }
}