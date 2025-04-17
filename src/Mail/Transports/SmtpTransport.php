<?php

namespace Axiom\Mail\Transports;

use Axiom\Mail\Contracts\Transport;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception as PHPMailerException;

class SmtpTransport implements Transport
{
    protected $config;
    protected $mailer;

    public function __construct(array $config)
    {
        $this->config = $config;
        $this->mailer = new PHPMailer(true);
        $this->configureMailer();
    }

    public function send(array $message)
    {
        try {
            $this->prepareMessage($message);
            return $this->mailer->send();
        } catch (PHPMailerException $e) {
            throw new MailException($e->getMessage(), $e->getCode(), $e);
        }
    }

    protected function configureMailer()
    {
        $this->mailer->isSMTP();
        $this->mailer->Host = $this->config['host'];
        $this->mailer->Port = $this->config['port'];
        $this->mailer->SMTPAuth = $this->config['auth'];
        $this->mailer->Username = $this->config['username'];
        $this->mailer->Password = $this->config['password'];
        $this->mailer->SMTPSecure = $this->config['encryption'];
        $this->mailer->SMTPOptions = $this->config['options'] ?? [];
    }

    protected function prepareMessage(array $message)
    {
        $this->mailer->setFrom(
            $message['from']['address'], 
            $message['from']['name'] ?? ''
        );

        $this->mailer->addAddress(
            $message['to']['address'], 
            $message['to']['name'] ?? ''
        );

        foreach ($message['cc'] as $cc) {
            $this->mailer->addCC($cc['address'], $cc['name'] ?? '');
        }

        foreach ($message['bcc'] as $bcc) {
            $this->mailer->addBCC($bcc['address'], $bcc['name'] ?? '');
        }

        $this->mailer->Subject = $message['subject'];
        $this->mailer->Body = $message['html'];
        $this->mailer->AltBody = $message['text'] ?? '';

        foreach ($message['attachments'] as $attachment) {
            $this->mailer->addAttachment(
                $attachment['file'],
                $attachment['options']['name'] ?? '',
                $attachment['options']['encoding'] ?? 'base64',
                $attachment['options']['type'] ?? '',
                $attachment['options']['disposition'] ?? 'attachment'
            );
        }
    }
}