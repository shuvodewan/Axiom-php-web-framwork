<?php

namespace Axiom\Mail\Transports;

use Axiom\Mail\Contracts\Transport;
use RuntimeException;

class SendmailTransport implements Transport
{
    protected $command;
    protected $stream;

    public function __construct(array $config)
    {
        $this->command = $config['command'];
    }

    public function send(array $message)
    {
        $this->openStream();
        $this->writeHeaders($message);
        $this->writeBody($message);
        return $this->closeStream();
    }

    protected function openStream()
    {
        $this->stream = @popen($this->command, 'w');

        if (!is_resource($this->stream)) {
            throw new RuntimeException(
                "Could not open sendmail stream with command [{$this->command}]"
            );
        }
    }

    protected function writeHeaders(array $message)
    {
        $headers = [
            'From: ' . $this->formatAddress($message['from']),
            'To: ' . $this->formatAddress($message['to']),
            'Subject: ' . $message['subject'],
            'MIME-Version: 1.0',
            'Content-Type: text/html; charset=utf-8',
        ];

        foreach ($message['cc'] as $cc) {
            $headers[] = 'Cc: ' . $this->formatAddress($cc);
        }

        foreach ($message['bcc'] as $bcc) {
            $headers[] = 'Bcc: ' . $this->formatAddress($bcc);
        }

        fwrite($this->stream, implode("\r\n", $headers) . "\r\n\r\n");
    }

    protected function writeBody(array $message)
    {
        fwrite($this->stream, $message['html'] . "\r\n");

        if (!empty($message['text'])) {
            fwrite($this->stream, "\r\n--boundary\r\n");
            fwrite($this->stream, "Content-Type: text/plain; charset=utf-8\r\n\r\n");
            fwrite($this->stream, $message['text'] . "\r\n");
        }
    }

    protected function closeStream()
    {
        $status = pclose($this->stream);
        
        if ($status !== 0) {
            throw new RuntimeException(
                "Sendmail returned non-zero status [{$status}]"
            );
        }
        
        return true;
    }

    protected function formatAddress(array $address)
    {
        return isset($address['name'])
            ? "{$address['name']} <{$address['address']}>"
            : $address['address'];
    }
}