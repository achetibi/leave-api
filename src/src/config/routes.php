<?php

App\core\App::middlewares(['auth', 'ensureApi', 'permission'])
    // Auth
    ->get('/api/auth/me', \App\controllers\AuthController::class, 'me')
    ->post('/api/auth/login', \App\controllers\AuthController::class, 'login')

    // Employees
    ->post('/api/employees', \App\controllers\EmployeeController::class, 'create')
    ->put('/api/employees/([0-9]+)', \App\controllers\EmployeeController::class, 'update')
    ->delete('/api/employees/([0-9]+)', \App\controllers\EmployeeController::class, 'delete')

    // Managers
    ->post('/api/managers', \App\controllers\ManagerController::class, 'create')
    ->put('/api/managers/([0-9]+)', \App\controllers\ManagerController::class, 'update')
    ->delete('/api/managers/([0-9]+)', \App\controllers\ManagerController::class, 'delete')

    // Users
    ->get('/api/users', \App\controllers\UserController::class, 'index')
    ->get('/api/users/([0-9]+)', \App\controllers\UserController::class, 'show')

    // Structures
    ->get('/api/structures', \App\controllers\StructureController::class, 'index')
    ->get('/api/structures/([0-9]+)', \App\controllers\StructureController::class, 'show')
    ->post('/api/structures', \App\controllers\StructureController::class, 'create')
    ->put('/api/structures/([0-9]+)', \App\controllers\StructureController::class, 'update')
    ->delete('/api/structures/([0-9]+)', \App\controllers\StructureController::class, 'delete')
    ->get('/api/structures/([0-9]+)/employees', \App\controllers\StructureController::class, 'employees')

    // Leave Requests
    ->get('/api/requests', \App\controllers\RequestController::class, 'index')
    ->get('/api/requests/([0-9]+)', \App\controllers\RequestController::class, 'show')
    ->post('/api/requests', \App\controllers\RequestController::class, 'create')
    ->put('/api/requests/([0-9]+)', \App\controllers\RequestController::class, 'update')
    ->delete('/api/requests/([0-9]+)', \App\controllers\RequestController::class, 'delete');
