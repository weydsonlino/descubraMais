<?php

$router->addRoute('GET', '/users', 'UserController@index');
$router->addRoute('GET', '/user', 'UserController@getOne');
$router->addRoute('POST', '/login', 'LoginController@login');
$router->addRoute('POST', '/cadastro', 'UserController@store');
$router->addRoute('GET', '/TiposPontoTuristico', 'TipoPontoTuristicoController@index');
$router->addRoute('GET', '/TipoPontoTuristico/{id}', 'TipoPontoTuristicoController@getOne');
$router->addRoute('POST', '/AdicionarTipoPontoTuristico', 'TipoPontoTuristicoController@store');
$router->addRoute('PUT', '/EditarTipoPontoTuristico', 'TipoPontoTuristicoController@update');
$router->addRoute('DELETE', '/DeletarTipoPontoTuristico/{id}', 'TipoPontoTuristicoController@delete');

?>