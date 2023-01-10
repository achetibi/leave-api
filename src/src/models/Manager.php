<?php

namespace App\models;

class Manager extends User
{
    /**
     * @var int
     */
    public int $role = self::ROLE_MANAGER;

    public function leave()
    {

    }
}
