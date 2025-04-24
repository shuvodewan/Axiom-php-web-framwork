<?php

namespace Axiom\Mail\Transports;

use Axiom\Mail\Contracts\Transport;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use RuntimeException;

/**
 * Mailgun API transport for sending emails through Mailgun's HTTP API.
 */
class MailgunTransport implements Transport
{
    /**
     * @var Client The HTTP client instance
     */
    protected Client $client;

    /**
     * @var array Configuration array
     */
    protected array $config;

    /**
     * Create a new Mailgun transport instance.
     *
     * @param array $config Configuration array containing:
     *                      - domain: Mailgun domain
     *                      - secret: Mailgun API key
     *                      - endpoint: API endpoint (e.g., api.mailgun.net)
     *                      - scheme: HTTP scheme (https)
     */
    public function __construct(array $config)
    {
        $this->config = $config;
        $this->client = new Client([
            'base_uri' => "{$this->config['scheme']}://{$this->config['endpoint']}/",
            'timeout' => 15,
        ]);
    }

    /**
     * Send an email through Mailgun API.
     *
     * @param array $message The message data containing:
     *                       - from: Sender address
     *                       - to: Recipient address
     *                       - subject: Email subject
     *                       - html: HTML content
     *                       - text: Plain text content (optional)
     *                       - cc: CC addresses (optional)
     *                       - bcc: BCC addresses (optional)
     *                       - attachments: File attachments (optional)
     *
     * @return array Mailgun API response
     *
     * @throws RuntimeException When the API request fails
     */
    public function send(array $message): array
    {
        try {
            $response = $this->client->post(
                "{$this->config['domain']}/messages",
                [
                    'auth' => ['api', $this->config['secret']],
                    'form_params' => $this->buildFormParams($message),
                ]
            );

            $contents = $response->getBody()->getContents();
            return json_decode($contents, true) ?? [];
        } catch (GuzzleException $e) {
            throw new RuntimeException(
                "Mailgun API Error: " . $e->getMessage(),
                $e->getCode(),
                $e
            );
        }
    }

    /**
     * Build form parameters for Mailgun API request.
     *
     * @param array $message The message data
     *
     * @return array Form parameters for the API request
     */
    protected function buildFormParams(array $message): array
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

        if (!empty($message['cc'])) {
            $params['cc'] = array_map([$this, 'formatAddress'], $message['cc']);
        }

        if (!empty($message['bcc'])) {
            $params['bcc'] = array_map([$this, 'formatAddress'], $message['bcc']);
        }

        if (!empty($message['attachments'])) {
            $params['attachment'] = array_map(
                fn (array $attachment) => [
                    'filePath' => $attachment['file'],
                    'filename' => $attachment['options']['name'] ?? basename($attachment['file']),
                ],
                $message['attachments']
            );
        }

        return $params;
    }

    /**
     * Format an email address with optional name.
     *
     * @param array $address Address array containing:
     *                       - address: Email address
     *                       - name: Optional display name
     *
     * @return string Formatted address string
     */
    protected function formatAddress(array $address): string
    {
        return isset($address['name'])
            ? "{$address['name']} <{$address['address']}>"
            : $address['address'];
    }
}