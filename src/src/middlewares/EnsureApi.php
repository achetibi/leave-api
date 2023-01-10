<?php

namespace App\middlewares;

use App\core\BaseMiddleware;

class EnsureApi extends BaseMiddleware
{
    /**
     * @param array $route
     * @param string|null $uri
     * @return bool
     */
    public function handle(array $route = [], ?string $uri = null): bool
    {
        $headers = getallheaders();
        $acceptHeader = array_key_exists('Accept', $headers) && !empty(trim($headers['Accept']));
        $contentTypeHeader = array_key_exists('Content-Type', $headers) && !empty(trim($headers['Content-Type']));

        if($acceptHeader && $contentTypeHeader) {
            return $this->check($headers['Accept']) && $this->check($headers['Content-Type']);
        }

        return true;
    }

    /**
     * @param string|null $value
     * @return bool
     */
    private function check(?string $value): bool
    {
        return $value === 'application/json';
    }
}
