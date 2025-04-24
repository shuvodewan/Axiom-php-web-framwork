<?php
// Axiom/Mail/Transports/SendmailTransport.php

namespace Axiom\Mail\Transports;


use Symfony\Component\Mailer\Mailer;
use Axiom\Mail\Contracts\Transport;
use Symfony\Component\Mime\Email;
use Symfony\Component\Mailer\Transport\SendmailTransport as TransportSendmailTransport;

class SendmailTransport implements Transport
{
    protected $mailer;

    public function __construct(array $config)
    {
        $command = $config['command'] ?? '/usr/sbin/sendmail -bs';
        $transport = new TransportSendmailTransport($command);
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
