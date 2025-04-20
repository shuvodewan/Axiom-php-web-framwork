<?php

namespace Axiom\Mail;


abstract class Mailable
{
    private $mailer;

    public function __construct()
    {
        $this->mailer = New MailService();
    }

    abstract public function mailTo() :string;
    abstract public function build();
    abstract public function subject() :string;


    public function send()
    {
        $this->build();
        
        return $this->mailer->to($this->mailTo())
            ->subject($this->subject())
            ->from(config('mail.global.from.address'),config('mail.global.from.name'))
            ->send();
    }


    public function __call($name, $arguments)
    {
        $this->mailer->$name(...$arguments);
        return $this;
    }


}