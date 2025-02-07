<?php

//CRUD User Routes
$router->addRoute('GET', '/user', 'UserController@index');
$router->addRoute('GET', '/user/{cpf}', 'UserController@getOne');
$router->addRoute('POST', '/cadastro', 'UserController@store');
$router->addRoute('PUT', '/user', 'UserController@update');
$router->addRoute('DELETE', '/user/{cpf}', 'UserController@delete');

//Autenthicate Route
$router->addRoute('POST', '/login', 'LoginController@login');
$router->addRoute('POST', '/logout', 'LoginController@logout');

//CRUD TPT Routes
$router->addRoute('GET', '/tipopontoturistico', 'TipoPontoTuristicoController@index');
$router->addRoute('GET', '/tipopontoturistico/{id}', 'TipoPontoTuristicoController@getOne');
$router->addRoute('POST', '/tipopontoturistico', 'TipoPontoTuristicoController@store');
$router->addRoute('PUT', '/tipopontoturistico', 'TipoPontoTuristicoController@update');
$router->addRoute('DELETE', '/tipopontoturistico/{id}', 'TipoPontoTuristicoController@delete');

//CRUD Interesses Viajantes Routes
$router->addRoute('POST', '/viajanteInteresses', 'InteresseViajanteController@store');

//CRUD Ponto Turistico Routes
$router->addRoute('POST', '/pontoturistico', 'PontoTuristicoController@store');
$router->addRoute('GET', '/pontoturistico', 'PontoTuristicoController@index');
$router->addRoute('GET', '/pontoturistico/{id}', 'PontoTuristicoController@show');

//CRUD Regiao Routes
$router->addRoute('POST', '/regiao', 'RegiaoController@store');
?>