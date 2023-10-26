<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('migrate', 'Migrate::index');

$routes->get('/', 'Home::index');
$routes->get('tasks', 'Tasks::index');
