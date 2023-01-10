<?php

return [
    'auth' => App\middlewares\CheckAuth::class,
    'ensureApi' => App\middlewares\EnsureApi::class,
    'permission' => App\middlewares\CheckPermission::class,
];
