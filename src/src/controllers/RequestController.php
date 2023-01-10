<?php

namespace App\controllers;

use App\models\Request;
use App\models\User;
use App\traits\ApiResponse;
use App\core\BaseController;

class RequestController extends BaseController
{
    use ApiResponse;

    /**
     * Show authenticated requests
     *
     * @return false|string
     */
    public function index()
    {
        if (user()->getRole() === User::ROLE_EMPLOYEE) {
            return $this->response(200, 'OK', Request::all());
        }

        return $this->response(200, 'OK', Request::all());
    }

    /**
     * Show request by ID
     *
     * @param $id
     * @return false|string
     * @throws \ReflectionException
     */
    public function show($id)
    {
        $request = Request::find($id);

        if ($request === null || $request->user_id !== user()->id) {
            return $this->notFound();
        }

        return $this->response(200, 'OK', $request);
    }

    /**
     * Create new request
     *
     * @return false|string
     * @throws \ReflectionException
     */
    public function create()
    {
        $data = request();

        ($request = new Request())
            ->setTitle($data['title'])
            ->setDateStart($data['date_start'])
            ->setDateEnd($data['date_end'])
            ->setStatus(Request::STATUS_PENDING)
            ->setUserId(user()->getId());

        if ($request->create()) {
            return $this->response(200, 'OK', $request);
        }

        return $this->response(500, 'ERROR');
    }

    /**
     * Update request by ID
     *
     * @param $id
     * @return false|string
     */
    public function update($id)
    {
        $data = request();
        $request = Request::find($id);

        if ($request === null) {
            return $this->notFound();
        }

        $request
            ->setComment($data['comment'])
            ->setStatus($data['status']);

        if ($request->update()) {
            return $this->response(200, 'OK', $request);
        }

        return $this->response(500, 'ERROR');
    }

    /**
     * Delete request by ID
     *
     * @param $id
     * @return false|string
     */
    public function delete($id)
    {
        $request = Request::find($id);

        if ($request === null) {
            return $this->notFound();
        }

        if ($request->delete()) {
            return $this->response(200, 'OK');
        }

        return $this->response(500, 'ERROR');
    }
}
