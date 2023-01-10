<?php

namespace App\core;

class BaseMiddleware
{
    /**
     * Routes to ignore by the middleware
     *
     * @var array
     */
    public array $except = [];

    /**
     * Routes to set authorization on.
     * Roles not present are not allowed to
     * access the routes in this array.
     *
     * @example :
     * [
     *      '/api/example' => [
     *          'GET' => [ROLE_EMPLOYEE, ROLE MANAGER],
     *          'POST' => [ROLE_MANAGER]
     *      ]
     * ]
     */
    public array $authorizations = [];
}
