<?php

namespace App\Authentication\Transports\Mails;

use Axiom\Mail\Mailable;

class PasswordResetMail extends Mailable
{
    public function __construct()
    {
        parent::__construct();
    }

    public function mailTo() :string
    {
        return "shuvodewan.sky@gmail.com";
    }

    public function subject() :string
    {
        return "Forget password mail";
    }

    public function build(){
        $this->view('mails.forgetPassword');
    }
}