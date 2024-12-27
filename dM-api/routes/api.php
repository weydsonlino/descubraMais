<?php

$router->addRoute('GET', '/users', 'UserController@index');
$router->addRoute('GET', '/user', 'UserController@getOne');
$router->addRoute('POST', '/login', 'LoginController@login');
$router->addRoute('POST', '/cadastro', 'UserController@store');
?>