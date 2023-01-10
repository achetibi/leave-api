<?php

namespace App\controllers;

use App\models\Structure;
use App\traits\ApiResponse;
use App\core\BaseController;

class StructureController extends BaseController
{
    use ApiResponse;

    /**
     * Show structures
     *
     * @return false|string
     */
    public function index()
    {
        return $this->response(200, 'OK', Structure::all());
    }

    /**
     * Show structure by ID
     *
     * @param $id
     * @return false|string
     */
    public function show($id)
    {
        $structure = Structure::find($id);

        if ($structure === null) {
            return $this->notFound();
        }

        return $this->response(200, 'OK', $structure);
    }

    /**
     * Create new structure
     *
     * @return false|string
     */
    public function create()
    {
        $data = request();

        ($structure = new Structure())
            ->setName($data['name'])
            ->setParentId($data['parent_id'] ?? null)
            ->setManagerId($data['manager_id'] ?? null);

        if ($structure->create()) {
            return $this->response(200, 'OK', $structure);
        }

        return $this->response(500, 'ERROR');
    }

    /**
     * Update structure by ID
     *
     * @param $id
     * @return false|string
     */
    public function update($id)
    {
        $data = request();
        $structure = Structure::find($id);

        if ($structure === null) {
            return $this->notFound();
        }

        $structure
            ->setName($data['name'])
            ->setParentId($data['parent_id'] ?? null)
            ->setManagerId($data['manager_id'] ?? null);

        if ($structure->update()) {
            return $this->response(200, 'OK', $structure);
        }

        return $this->response(500, 'ERROR');
    }

    /**
     * Delete structure by ID
     *
     * @param $id
     * @return false|string
     */
    public function delete($id)
    {
        $structure = Structure::find($id);

        if ($structure === null) {
            return $this->notFound();
        }

        if ($structure->delete()) {
            return $this->response(200, 'OK');
        }

        return $this->response(500, 'ERROR');
    }

    /**
     * Show structure's employees
     *
     * @param $id
     * @return false|string
     */
    public function employees($id)
    {
        $structure = Structure::find($id);

        if ($structure === null) {
            return $this->notFound();
        }

        return $this->response(200, 'OK', $structure->employees());
    }
}
