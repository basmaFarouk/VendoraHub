<?php

namespace App\Services;

use App\Mail\GenericEmail;
use Illuminate\Support\Facades\Mail;

class MailService {

    public static function send(string $to, string $subject, string $body) {
        
        Mail::to($to)->send(new GenericEmail($subject, $body));
    }
}
