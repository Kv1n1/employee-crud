<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Employee::index');
$routes->group('api', function($routes) {
    $routes->resource('employees', ['controller' => 'Employee']);
    // Handle CORS preflight for all employee endpoints
    $routes->options('employees', 'Employee::index');
    $routes->options('employees/(:any)', 'Employee::index');
});
$routes->resource('employees', ['controller' => 'Employee']);
