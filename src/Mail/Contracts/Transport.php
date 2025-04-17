<?php

namespace Axiom\Mail\Contracts;

interface Transport
{
    /**
     * Send the given message
     *
     * @param array $message Message data including:
     *                       - from: array with address/name
     *                       - to: array with address/name
     *                       - cc: array of arrays with address/name
     *                       - bcc: array of arrays with address/name
     *                       - subject: string
     *                       - html: string
     *                       - text: string|null
     *                       - attachments: array of file paths
     * @return mixed
     */
    public function send(array $message);
}