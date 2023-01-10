<?php

namespace App\traits;

trait ApiResponse
{
    /**
     * Return an unauthorized response
     *
     * @param array $data
     * @return false|string
     */
    public function unauthorized(array $data = []): bool|string
    {
        return $this->response(401, 'Unauthorized', $data);
    }

    /**
     * Return a not found response
     *
     * @param array $data
     * @return false|string
     */
    public function notFound(array $data = []): bool|string
    {
        return $this->response(404, 'Not Found', $data);
    }

    /**
     * Return a success response
     *
     * @param array $data
     * @return false|string
     */
    public function success(array $data = []): bool|string
    {
        return $this->response(200, 'OK', $data);
    }

    /**
     * Return a specific response
     *
     * @param int $status
     * @param string $message
     * @param array|object $data
     * @return false|string
     */
    private function response(int $status, string $message, array|object $data = []): bool|string
    {
        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Headers: access");
        header("Content-Type: application/json; charset=UTF-8");
        header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
        header("HTTP/1.0 $status $message");

        return json_encode([
            'status' => $status,
            'message' => $message,
            'data' => sanitize($data)
        ]);
    }
}
