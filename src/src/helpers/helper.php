<?php

if (!function_exists('request')) {
    /**
     * @param bool $associative
     * @return mixed
     */
    function request(bool $associative = true): mixed {
        return json_decode(file_get_contents("php://input"), $associative);
    }
}

if (!function_exists('sanitize')) {
    /**
     * @param $data
     * @return mixed
     */
    function sanitize($data): mixed {
        if (is_array($data)) {
            foreach ($data as $key => $value) {
                $data[$key] = sanitize($value);
            }
        }
        elseif (is_object($data)) {
            foreach ($data as $key => $value) {
                $data->{$key} = sanitize($value);
            }
        }
        else {
            $decoded = json_decode($data, true);

            if (json_last_error() === JSON_ERROR_NONE) {
                $data = $decoded;
            }
        }

        return $data;
    }
}

if (!function_exists('base_url')) {
    /**
     * @return string
     */
    function base_url(): string {
        $baseUrl = getenv('BASE_URL');

        if (!$baseUrl || empty($baseUrl)) {
            $baseUrl = $_SERVER['HTTP_HOST'];
        }

        return $baseUrl;
    }
}

if (!function_exists('request_method')) {
    /**
     * @return string
     */
    function request_method(): string {
        return $_SERVER['REQUEST_METHOD'];
    }
}

if (!function_exists('user')) {
    /**
     * @return \App\models\User
     * @throws ReflectionException
     */
    function user() {
        global $user;

        /**
         * @var $object \App\models\User
         */
        $object = (new ReflectionClass(\App\models\User::class))->newInstance();

        $object
            ->setId($user->id)
            ->setLastName($user->last_name)
            ->setFirstName($user->first_name)
            ->setStatus($user->status)
            ->setRole($user->role)
            ->setStructureId($user->structure_id);

        return $object;
    }
}
