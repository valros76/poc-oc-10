<?php

use Core\Router;

/** @var Router $router */
$router->post('/api/audit', 'Controllers\AuditController@process');
$router->post('/api/audit.php', 'Controllers\AuditController@process');