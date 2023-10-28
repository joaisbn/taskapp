<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('migrate', 'Migrate::index');

$routes->get('/', 'Home::index');
$routes->get('tasks', 'Tasks::index');
$routes->get('tasks/show/(:num)', 'Tasks::show/$1');
$routes->get('tasks/new', 'Tasks::new');
$routes->post('tasks/create', 'Tasks::create');
