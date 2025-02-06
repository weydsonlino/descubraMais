<?php

//CRUD User Routes
$router->addRoute('GET', '/users', 'UserController@index');
$router->addRoute('GET', '/user/{cpf}', 'UserController@getOne');
$router->addRoute('POST', '/cadastro', 'UserController@store');
$router->addRoute('PUT', '/user', 'UserController@update');
$router->addRoute('DELETE', '/user', 'UserController@delete');

//Autenthicate Route
$router->addRoute('POST', '/login', 'LoginController@login');
$router->addRoute('POST', '/logout', 'LoginController@logout');

//CRUD TPT Routes
$router->addRoute('GET', '/TiposPontoTuristico', 'TipoPontoTuristicoController@index');
$router->addRoute('GET', '/TipoPontoTuristico/{id}', 'TipoPontoTuristicoController@getOne');
$router->addRoute('POST', '/TipoPontoTuristico', 'TipoPontoTuristicoController@store');
$router->addRoute('PUT', '/TipoPontoTuristico', 'TipoPontoTuristicoController@update');
$router->addRoute('DELETE', '/TipoPontoTuristico/{id}', 'TipoPontoTuristicoController@delete');

//CRUD Interesses Viajantes Routes
$router->addRoute('POST', '/ViajanteInteresses', 'InteresseViajanteController@store');

//CRUD Ponto Turistico Routes
$router->addRoute('POST', '/pontoturistico', 'PontoTuristicoController@store');
$router->addRoute('GET', '/pontoturistico', 'PontoTuristicoController@index');
$router->addRoute('GET', '/pontoturistico/{id}', 'PontoTuristicoController@show');

//CRUD Regiao Routes
$router->addRoute('POST', '/Regiao', 'RegiaoController@store');
?>