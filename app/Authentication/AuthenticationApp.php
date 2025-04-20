<?php

namespace App\Authentication;

use App\Authentication\Transports\Handlers\MailHandler;
use App\Authentication\Transports\Jobs\MailJob;
use Axiom\Application\App;

class AuthenticationApp extends App
{
    public array $jobs=[MailJob::class=>[MailHandler::class]];
}