<?php

namespace App\models;

class Employee extends User
{
    /**
     * @var int
     */
    public int $role = self::ROLE_EMPLOYEE;

    public function leave()
    {

    }
}
