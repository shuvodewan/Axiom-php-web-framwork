<?php
// Axiom/Mail/MailManager.php

namespace Axiom\Mail;

use Axiom\Mail\Transports\MailgunTransport;
use Axiom\Mail\Transports\PostmarkTransport;
use Axiom\Mail\Transports\SendmailTransport;
use Axiom\Mail\Transports\SmtpTransport;
use InvalidArgumentException;

class MailManager
{
    protected $drivers = [];

    public function driver($driver = null)
    {
        $driver = $driver ?: $this->getDefaultDriver();

        if (!isset($this->drivers[$driver])) {
            $this->drivers[$driver] = $this->createDriver($driver);
        }

        return $this->drivers[$driver];
    }

    protected function createDriver($driver)
    {
        $method = 'create' . ucfirst($driver) . 'Driver';
        if (method_exists($this, $method)) {
            return $this->$method();
        }

        throw new InvalidArgumentException("Driver [$driver] not supported.");
    }

    protected function createSmtpDriver()
    {
        $config = config('mail.drivers.smtp');
        return new SmtpTransport($config);
    }

    protected function createMailgunDriver()
    {
        $config = config('mail.drivers.mailgun');

        return new MailgunTransport([
            'domain' => $config['domain'],
            'secret' => $config['secret'],
            'endpoint' => $config['endpoint'] ?? 'api.mailgun.net',
            'region' => $config['region'] ?? null // 'us' or 'eu'
        ]);
    }

    protected function createPostmarkDriver()
    {
        $config = config('mail.drivers.postmark');
        return new PostmarkTransport($config['token']);
    }

    protected function createSendmailDriver()
    {
        $config = config('mail.drivers.sendmail');
        return new SendmailTransport($config);
    }

    public function getDefaultDriver()
    {
        return config('mail.default');
    }
}
