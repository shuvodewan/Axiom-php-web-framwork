<?php

namespace App\Authentication\Transports\Jobs;

use App\Authentication\Transports\Mails\PasswordResetMail;
use Axiom\Messenger\JobContract;

class MailJob 
{
    public function sendMail(){
        (new PasswordResetMail())->send();
    }
} 