<?php

namespace App\controllers;

use App\models\User;
use App\models\Manager;
use App\traits\ApiResponse;
use App\core\BaseController;

class ManagerController extends BaseController
{
    use ApiResponse;

    /**
     * Show managers
     *
     * @return false|string
     */
    public function index()
    {
        return $this->response(200, 'OK', Manager::all());
    }

    /**
     * Show manager by ID
     *
     * @param $id
     * @return false|string
     */
    public function show($id)
    {
        $manager = Manager::find($id);

        if ($manager === null) {
            return $this->notFound();
        }

        return $this->response(200, 'OK', $manager);
    }

    /**
     * Create new manager
     *
     * @return false|string
     */
    public function create()
    {
        $data = request();

        ($manager = new Manager())
            ->setEmail($data['email'])
            ->setPassword($data['password'])
            ->setFirstName($data['first_name'])
            ->setLastName($data['last_name'])
            ->setStatus(User::STATUS_ACTIVE)
            ->setStructureId($data['structure_id']);

        if ($manager->create()) {
            return $this->response(200, 'OK', $manager);
        }

        return $this->response(500, 'ERROR');
    }

    /**
     * Update manager by ID
     *
     * @param $id
     * @return false|string
     */
    public function update($id)
    {
        $data = request();
        $manager = Manager::find($id);

        if ($manager === null) {
            return $this->notFound();
        }

        $manager
            ->setEmail($data['email'])
            ->setFirstName($data['first_name'])
            ->setLastName($data['last_name'])
            ->setStatus($data['status'])
            ->setStructureId($data['structure_id']);

        if ($manager->update()) {
            return $this->response(200, 'OK', $manager);
        }

        return $this->response(500, 'ERROR');
    }

    /**
     * Delete a manager by ID
     *
     * @param $id
     * @return false|string
     */
    public function delete($id)
    {
        $manager = Manager::find($id);

        if ($manager === null) {
            return $this->notFound();
        }

        if ($manager->delete()) {
            return $this->response(200, 'OK');
        }

        return $this->response(500, 'ERROR');
    }
}
