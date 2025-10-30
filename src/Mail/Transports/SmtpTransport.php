<?php
// Axiom/Mail/Transports/SmtpTransport.php

namespace Axiom\Mail\Transports;

use Symfony\Component\Mailer\Transport\Smtp\EsmtpTransport;
use Symfony\Component\Mailer\Mailer;
use Symfony\Component\Mime\Email;
use Axiom\Mail\Contracts\Transport;

class SmtpTransport implements Transport
{
    protected $config;
    protected $mailer;

    public function __construct(array $config)
    {
        $this->config = $config;
        $transport = new EsmtpTransport(
            $config['host'],
            $config['port'],
            $config['encryption'] === 'tls',
            null
        );

        $transport->setUsername($config['username']);
        $transport->setPassword($config['password']);

        $this->mailer = new Mailer($transport);
    }

    public function send(array $message)
    {
        $email = (new Email())
            ->from($this->formatAddress($message['from']))
            ->to($this->formatAddress($message['to']))
            ->subject($message['subject'])
            ->html($message['html']);

        if (!empty($message['text'])) {
            $email->text($message['text']);
        }

        foreach ($message['cc'] as $cc) {
            $email->addCc($this->formatAddress($cc));
        }

        foreach ($message['bcc'] as $bcc) {
            $email->addBcc($this->formatAddress($bcc));
        }

        foreach ($message['attachments'] as $attachment) {
            $email->attachFromPath(
                $attachment['file'],
                $attachment['options']['name'] ?? null,
                $attachment['options']['type'] ?? null
            );
        }

        $this->mailer->send($email);
        return true;
    }

    protected function formatAddress(array $address): string
    {
        return $address['name']
            ? sprintf('%s <%s>', $address['name'], $address['address'])
            : $address['address'];
    }
}
