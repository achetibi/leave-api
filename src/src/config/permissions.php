<?php

use App\models\User;

return [
    '/api/employees' => [
        'POST' => [User::ROLE_MANAGER]    // Only manager can create employee
    ],
    '/api/employees/([0-9]+)' => [
        'PUT' => [User::ROLE_MANAGER],    // Only manager can update employee
        'DELETE' => [User::ROLE_MANAGER]  // Only manager can delete employee
    ],
    '/api/managers' => [
        'POST' => [User::ROLE_MANAGER]    // Only manager can create manager
    ],
    '/api/managers/([0-9]+)' => [
        'PUT' => [User::ROLE_MANAGER],    // Only manager can update manager
        'DELETE' => [User::ROLE_MANAGER]  // Only manager can delete manager
    ],
    '/api/structures' => [
        'GET' => [User::ROLE_MANAGER],    // Only manager can view structures
        'POST' => [User::ROLE_MANAGER]    // Only manager can create structure
    ],
    '/api/structures/([0-9]+)' => [
        'GET' => [User::ROLE_MANAGER],    // Only manager can view structure
        'PUT' => [User::ROLE_MANAGER],    // Only manager can update structure
        'DELETE' => [User::ROLE_MANAGER]  // Only manager can delete structure
    ],
    '/api/structures/([0-9]+)/employees' => [
        'GET' => [User::ROLE_MANAGER]     // Only manager can view structure's employees
    ],
    '/api/requests/([0-9]+)' => [
        'PUT' => [User::ROLE_MANAGER],    // Only manager can update requests
    ],
];
