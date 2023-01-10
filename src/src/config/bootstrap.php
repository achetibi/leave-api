<?php

try {
    Dotenv\Dotenv::createUnsafeImmutable(ROOT_DIRECTORY)->safeLoad();
    App\core\App::instance()->run();
} catch (ReflectionException $e) {
    if (getenv('APP_ENV') === 'dev') {
        exit($e->getMessage());
    }

    exit();
}
