<?php

namespace Axiom\Mail;


abstract class Mailable
{
    protected $view;
    protected $mailer;
    protected $to;

    public function __construct($view)
    {
        $this->view = $view;
        $this->mailer = New MailService();

    }

    abstract public function build();

    public function send()
    {
        $this->build();
        
        return $this->mailer->to($this->to)
            ->from(config('mail.global.from.address'),config('mail.global.from.name'))
            ->send();
    }


    public function __call($name, $arguments)
    {
        $this->mailer->$name(...$arguments);
        return $this;
    }


}