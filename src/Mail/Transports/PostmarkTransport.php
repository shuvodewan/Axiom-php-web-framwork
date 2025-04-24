<?php
// src/Axiom/Mail/Transports/PostmarkTransport.php

namespace Axiom\Mail\Transports;

use Axiom\Mail\MailException;
use Axiom\Mail\Contracts\Transport;
use Symfony\Component\Mailer\Bridge\Postmark\Transport\PostmarkApiTransport;
use Symfony\Component\Mailer\Mailer;
use Symfony\Component\Mime\Email;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;

class PostmarkTransport implements Transport
{
    protected $mailer;

    public function __construct(string $apiToken)
    {
        $transport = PostmarkApiTransport::create($apiToken);
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
