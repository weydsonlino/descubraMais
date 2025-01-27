<?php

//CRUD User Routes
$router->addRoute('GET', '/users', 'UserController@index');
$router->addRoute('GET', '/user/{cpf}', 'UserController@getOne');
$router->addRoute('POST', '/cadastro', 'UserController@store');
$router->addRoute('PUT', '/user', 'UserController@update');
$router->addRoute('DELETE', '/user', 'UserController@delete');
//Login Route
$router->addRoute('POST', '/login', 'LoginController@login');
//logout Route
$router->addRoute('POST', '/logout', 'LoginController@logout');
//CRUD TPT Routes
$router->addRoute('GET', '/TiposPontoTuristico', 'TipoPontoTuristicoController@index');
$router->addRoute('GET', '/TipoPontoTuristico/{id}', 'TipoPontoTuristicoController@getOne');
$router->addRoute('POST', '/AdicionarTipoPontoTuristico', 'TipoPontoTuristicoController@store');
$router->addRoute('PUT', '/EditarTipoPontoTuristico', 'TipoPontoTuristicoController@update');
$router->addRoute('DELETE', '/DeletarTipoPontoTuristico/{id}', 'TipoPontoTuristicoController@delete');
//CRUD Interesses Viajantes Routes
$router->addRoute('POST', '/AddViajanteInteresses', 'InteresseViajanteController@store');

//CRUD Regiao Routes
$router->addRoute('POST', '/AddRegiao', 'RegiaoController@store');
?>