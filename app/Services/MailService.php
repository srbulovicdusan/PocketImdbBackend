<?php
namespace App\Services;
interface MailService{
    public function sendEmailToAdmins($text);
}