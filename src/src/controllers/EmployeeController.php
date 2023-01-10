<?php

namespace App\controllers;

use App\models\User;
use App\models\Employee;
use App\traits\ApiResponse;
use App\core\BaseController;

class EmployeeController extends BaseController
{
    use ApiResponse;

    /**
     * Show employees
     *
     * @return false|string
     */
    public function index()
    {
        return $this->response(200, 'OK', Employee::all());
    }

    /**
     * Show employee by ID
     *
     * @param $id
     * @return false|string
     */
    public function show($id)
    {
        $employee = Employee::find($id);

        if ($employee === null) {
            return $this->notFound();
        }

        return $this->response(200, 'OK', $employee);
    }

    /**
     * Create new employee
     *
     * @return false|string
     */
    public function create()
    {
        $data = request();

        ($employee = new Employee())
            ->setEmail($data['email'])
            ->setPassword($data['password'])
            ->setFirstName($data['first_name'])
            ->setLastName($data['last_name'])
            ->setStatus(User::STATUS_ACTIVE)
            ->setStructureId($data['structure_id']);

        if ($employee->create()) {
            return $this->response(200, 'OK', $employee);
        }

        return $this->response(500, 'ERROR');
    }

    /**
     * Update employee by ID
     *
     * @param $id
     * @return false|string
     */
    public function update($id)
    {
        $data = request();
        $employee = Employee::find($id);

        if ($employee === null) {
            return $this->notFound();
        }

        $employee
            ->setEmail($data['email'])
            ->setFirstName($data['first_name'])
            ->setLastName($data['last_name'])
            ->setStatus($data['status'])
            ->setStructureId($data['structure_id']);

        if ($employee->update()) {
            return $this->response(200, 'OK', $employee);
        }

        return $this->response(500, 'ERROR');
    }

    /**
     * Delete an employee by ID
     *
     * @param $id
     * @return false|string
     */
    public function delete($id)
    {
        $employee = Employee::find($id);

        if ($employee === null) {
            return $this->notFound();
        }

        if ($employee->delete()) {
            return $this->response(200, 'OK');
        }

        return $this->response(500, 'ERROR');
    }
}
