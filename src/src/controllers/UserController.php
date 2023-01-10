<?php

namespace App\controllers;

use App\models\User;
use App\traits\ApiResponse;
use App\core\BaseController;

class UserController extends BaseController
{
    use ApiResponse;

    /**
     * Show employees
     *
     * @return false|string
     */
    public function index()
    {
        return $this->response(200, 'OK', User::all());
    }

    /**
     * Show employee by ID
     *
     * @param $id
     * @return false|string
     */
    public function show($id)
    {
        $user = User::find($id);

        if ($user === null) {
            return $this->notFound();
        }

        return $this->response(200, 'OK', $user);
    }
}
