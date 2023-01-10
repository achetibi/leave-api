<?php

namespace App\middlewares;

use App\core\jwt\JWT;
use App\core\BaseMiddleware;

class CheckAuth extends BaseMiddleware
{
    /**
     * @var array
     */
    public array $except = [
        '/api/auth/login'
    ];

    /**
     * @param array $route
     * @param string|null $uri
     * @return bool
     */
    public function handle(array $route = [], ?string $uri = null): bool
    {
        global $user;

        $headers = getallheaders();

        if (in_array($uri, $this->except)) {
            return true;
        } else {
            if(array_key_exists('Authorization', $headers) && !empty(trim($headers['Authorization']))) {
                [$name, $token] = explode(" ", trim($headers['Authorization']));
                if(isset($token) && !empty(trim($token))) {
                    try {
                        $decoded = JWT::decode($token, getenv('TOKEN_ENCRYPTION_KEY'), ['HS256']);

                        if ($decoded) {
                            $user = $decoded->data;
                            return true;
                        }

                        return false;
                    } catch (\Exception $e) {
                        return false;
                    }
                }
            }
        }

        return false;
    }
}
