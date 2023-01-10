<?php

namespace App\middlewares;

use App\models\User;
use App\core\BaseMiddleware;

class CheckPermission extends BaseMiddleware
{
    /**
     * @inheritdoc
     */
    public array $authorizations = [];

    public function __construct()
    {
        $this->authorizations = require ROOT_DIRECTORY . '/src/config/permissions.php';
    }

    /**
     * @param array $route
     * @param string|null $uri
     * @return bool
     */
    public function handle(array $route = [], ?string $uri = null): bool
    {
        $method = strtoupper($route['method']);
        $checkUri = array_key_exists($uri, $this->authorizations);

        if ($checkUri && array_key_exists($method, $this->authorizations[$uri])) {
            $authorized = $this->authorizations[$uri][$method];
            return user() && in_array(user()->id, $authorized);
        }

        return true;
    }
}
