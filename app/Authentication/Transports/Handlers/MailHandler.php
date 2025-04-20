<?php

namespace App\Authentication\Transports\Handlers;

use Axiom\Messenger\HandlerContract;

class MailHandler implements HandlerContract
{
    public function __invoke($job)
    {
        $job->sendMail();
    }
}