<?php

namespace Axiom\Mail;

use Axiom\Views\TwigDriver;

class MailService
{
    protected $view;
    protected $from;
    protected $to;
    protected $cc = [];
    protected $bcc = [];
    protected $replyTo;
    protected $subject;
    protected $html;
    protected $text;
    protected $attachments = [];
    protected $driver;
    protected $queue;

    public function __construct()
    {
        $this->view = new TwigDriver();
        $this->driver = (new MailManager())->driver();
    }


    public function to($address, $name = null)
    {
        $this->to = $this->normalizeRecipient($address, $name);
        return $this;
    }

    public function from($address, $name = null)
    {
        $this->from = $this->normalizeRecipient($address, $name);
        return $this;
    }

    public function cc($address, $name = null)
    {
        $this->cc[] = $this->normalizeRecipient($address, $name);
        return $this;
    }

    public function bcc($address, $name = null)
    {
        $this->bcc[] = $this->normalizeRecipient($address, $name);
        return $this;
    }

    public function subject($subject)
    {
        $this->subject = $subject;
        return $this;
    }

    public function view($view, array $data = [], $plainView = null)
    {
        $this->html = $this->renderView($view, $data);
        
        if ($plainView) {
            $this->text = $this->renderView($plainView, $data);
        }
        
        return $this;
    }

    public function text($text)
    {
        $this->text = $text;
        return $this;
    }

    public function attach($file, array $options = [])
    {
        $this->attachments[] = [
            'file' => $file,
            'options' => $options
        ];
        return $this;
    }


    public function send()
    {
        if ($this->queue) {
            return $this->queueForSending();
        }

        return $this->driver->send($this->buildMessage());
    }

    protected function buildMessage()
    {
        return [
            'to' => $this->to,
            'from' => $this->from,
            'subject' => $this->subject,
            'html' => $this->html,
            'text' => $this->text,
            'cc' => $this->cc,
            'bcc' => $this->bcc,
            'attachments' => $this->attachments
        ];
    }

    protected function normalizeRecipient($address, $name = null)
    {
        if (is_array($address)) {
            return $address;
        }

        return ['address' => $address, 'name' => $name];
    }

    protected function renderView($view, $data)
    {
        return $this->view->render($view, $data);
    }
}