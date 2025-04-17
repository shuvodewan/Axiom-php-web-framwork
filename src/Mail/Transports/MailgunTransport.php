<?php

namespace Axiom\Mail\Transports;

use Axiom\Mail\Contracts\Transport;
use GuzzleHttp\Client;
use RuntimeException;

class MailgunTransport implements Transport
{
    protected $client;
    protected $config;

    public function __construct(array $config)
    {
        $this->config = $config;
        $this->client = new Client([
            'base_uri' => "{$this->config['scheme']}://{$this->config['endpoint']}/",
            'timeout' => 15,
        ]);
    }

    public function send(array $message)
    {
        try {
            $response = $this->client->post(
                "{$this->config['domain']}/messages",
                [
                    'auth' => ['api', $this->config['secret']],
                    'form_params' => $this->buildFormParams($message),
                ]
            );

            return json_decode($response->getBody()->getContents(), true);
        } catch (\Exception $e) {
            throw new RuntimeException(
                "Mailgun API Error: " . $e->getMessage(),
                $e->getCode(),
                $e
            );
        }
    }

    protected function buildFormParams(array $message)
    {
        $params = [
            'from' => $this->formatAddress($message['from']),
            'to' => $this->formatAddress($message['to']),
            'subject' => $message['subject'],
            'html' => $message['html'],
        ];

        if (!empty($message['text'])) {
            $params['text'] = $message['text'];
        }

        foreach ($message['cc'] as $cc) {
            $params['cc'] = $this->formatAddress($cc);
        }

        foreach ($message['bcc'] as $bcc) {
            $params['bcc'] = $this->formatAddress($bcc);
        }

        foreach ($message['attachments'] as $attachment) {
            $params['attachment'][] = [
                'filePath' => $attachment['file'],
                'filename' => $attachment['options']['name'] ?? basename($attachment['file']),
            ];
        }

        return $params;
    }

    protected function formatAddress(array $address)
    {
        return isset($address['name'])
            ? "{$address['name']} <{$address['address']}>"
            : $address['address'];
    }
}