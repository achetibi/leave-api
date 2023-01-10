<?php

namespace App\controllers;

use App\models\User;
use App\core\jwt\JWT;
use App\traits\ApiResponse;
use App\core\BaseController;

class AuthController extends BaseController
{
    use ApiResponse;

    /**
     * User authentication
     *
     * @return bool|string
     */
    public function login()
    {
        $data = request();
        $user = User::findByEmail($data['email']);

        if ($user && password_verify($data['password'], $user->getPassword())) {
            $issued_at = time();
            $expiration_time = $issued_at + getenv('TOKEN_EXPIRING_TIME');
            $issuer = getenv('TOKEN_ISSUER');

            $token = [
                'iat' => $issued_at,
                'exp' => $expiration_time,
                'iss' => $issuer,
                'data' => [
                    'id' => $user->id,
                    'email' => $user->email,
                    'first_name' => $user->first_name,
                    'last_name' => $user->last_name,
                    'role' => $user->role,
                    'status' => $user->status,
                    'structure_id' => $user->structure_id
                ]
            ];

            return $this->response(200, 'OK', [
                'token' => JWT::encode($token, getenv('TOKEN_ENCRYPTION_KEY'))
            ]);
        }

        return $this->unauthorized();
    }

    /**
     * Logged-in user information
     *
     * @return bool|string
     */
    public function me()
    {
        if (user() !== null) {
            return $this->response(200, 'OK', user());
        }

        return $this->unauthorized();
    }
}
