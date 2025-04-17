<?php

namespace Axiom\Mail;

use Axiom\Config\Repository as Config;
use Axiom\Mail\Transports\MailgunTransport;
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
        $method = 'create'.ucfirst($driver).'Driver';

        if (method_exists($this, $method)) {
            return $this->$method();
        }

        throw new InvalidArgumentException("Driver [$driver] not supported.");
    }

    protected function createSmtpDriver()
    {
        $config =config('mail.drivers.smtp');
        return new SmtpTransport([
            'host' => $config['host'],
            'port' => $config['port'],
            'encryption' => $config['encryption'],
            'username' => $config['username'],
            'password' => $config['password'],
            'timeout' => $config['timeout'],
            'options' => [
                'verify_peer' => $config['verify_peer'],
                'auth_mode' => $config['auth_mode'],
            ]
        ]);
    }

    protected function createMailgunDriver()
    {
        $config =config('mail.drivers.mailgun');
        return new MailgunTransport([
            'domain' => $config['domain'],
            'secret' => $config['secret'],
            'endpoint' => $config['endpoint'],
            'scheme' => $config['scheme'],
            'api_version' => $config['api_version'],
        ]);
    }

    protected function createSendmailDriver()
    {
        $config =config('mail.drivers.sendmail');
        return new SendmailTransport([
            'command' => $config['path'] . ' ' . $config['args'],
            'timeout' => $config['timeout'],
        ]);
    }


    public function getDefaultDriver()
    {
        return config('mail.default');
    }
}