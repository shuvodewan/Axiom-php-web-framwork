<?php

namespace Axiom\Facade;

use Axiom\Mail\MailService;

class Mail  implements FacadeContract
{

    use FacadeTrait;

    /**
     * Get the underlying instance of the `MailService` class.
     *
     * @return mailer The instance of `MailService`
     */
    public static function getInstance(): MailService
    {
        return new MailService();
    }
}