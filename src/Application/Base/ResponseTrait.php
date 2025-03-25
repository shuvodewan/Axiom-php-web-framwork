<?php

namespace Axiom\Application\Base;

use Axiom\Http\Response;

class ResponseTrait
{
    /**
     * Standard JSON response structure
     * 
     * @param mixed $data Main response data
     * @param int $status HTTP status code
     * @param string|null $message Optional message
     * @param array $meta Optional metadata (pagination, etc.)
     * @return void
     */
    protected function response(
        $data = null,
        int $status = 200,
        ?string $message = null,
        array $meta = []
    ): void {
        $response = [
            'success' => $status >= 200 && $status < 300,
            'status' => $status,
            'message' => $message ?? $this->getDefaultMessage($status),
            'data' => $data
        ];

        if (!empty($meta)) {
            $response['meta'] = $meta;
        }

        (new Response())->json($response, $status)->send();
    }

    /**
     * Get default message based on status code
     */
    private function getDefaultMessage(int $status): string
    {
        $messages = [
            // Success
            200 => 'Request successful',
            201 => 'Resource created successfully',
            204 => 'No content found',
            
            // Client errors
            400 => 'Bad request',
            401 => 'Unauthorized',
            403 => 'Forbidden',
            404 => 'Resource not found',
            422 => 'Validation failed',
            
            // Server errors
            500 => 'Internal server error',
            503 => 'Service temporarily unavailable'
        ];

        return $messages[$status] ?? '';
    }

    // Success Responses (2xx)
    
    /**
     * 200 OK response
     */
    protected function ok($data = null, ?string $message = null, array $meta = []): void
    {
        $this->response($data, 200, $message, $meta);
    }

    /**
     * 201 Created response
     */
    protected function created($data = null, ?string $message = null): void
    {
        $this->response($data, 201, $message);
    }

    /**
     * 204 No Content response
     */
    protected function noContent(?string $message = null): void
    {
        $this->response(null, 204, $message);
    }

    // Client Error Responses (4xx)

    /**
     * 400 Bad Request response
     */
    protected function badRequest(?string $message = null, $errors = null): void
    {
        $this->response($errors, 400, $message);
    }

    /**
     * 401 Unauthorized response
     */
    protected function unauthorized(?string $message = null): void
    {
        $this->response(null, 401, $message);
    }

    /**
     * 403 Forbidden response
     */
    protected function forbidden(?string $message = null): void
    {
        $this->response(null, 403, $message);
    }

    /**
     * 404 Not Found response
     */
    protected function notFound(?string $message = null): void
    {
        $this->response(null, 404, $message);
    }

    /**
     * 422 Unprocessable Entity response
     */
    protected function unprocessableEntity(?string $message = null, array $errors = []): void
    {
        $this->response(['errors' => $errors], 422, $message);
    }

    // Server Error Responses (5xx)

    /**
     * 500 Internal Server Error response
     */
    protected function serverError(?string $message = null, $error = null): void
    {
        $this->response($error, 500, $message);
    }

    /**
     * 503 Service Unavailable response
     */
    protected function serviceUnavailable(?string $message = null): void
    {
        $this->response(null, 503, $message);
    }

    // Helper methods

    /**
     * Paginated response
     */
    protected function paginated($data, int $total, int $perPage, int $currentPage, ?string $message = null): void
    {
        $meta = [
            'pagination' => [
                'total' => $total,
                'per_page' => $perPage,
                'current_page' => $currentPage,
                'last_page' => ceil($total / $perPage),
                'from' => ($currentPage - 1) * $perPage + 1,
                'to' => min($currentPage * $perPage, $total)
            ]
        ];

        $this->response($data, 200, $message, $meta);
    }
}