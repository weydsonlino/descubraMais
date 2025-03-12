<?php

//CRUD User Routes
$router->addRoute('GET', '/user', 'UserController@index');
$router->addRoute('GET', '/user/{cpf}', 'UserController@getOne');
$router->addRoute('POST', '/cadastro', 'UserController@store');
$router->addRoute('PUT', '/user', 'UserController@update');
$router->addRoute('DELETE', '/user/{cpf}', 'UserController@delete');

//Autenthicate Route
$router->addRoute('POST', '/login', 'AuthenticationController@login');
$router->addRoute('POST', '/logout', 'AuthenticationController@logout');

//CRUD TPT Routes
$router->addRoute('GET', '/tipospontosturisticos', 'TipoPontoTuristicoController@index');
$router->addRoute('GET', '/tipospontosturisticos/{id}', 'TipoPontoTuristicoController@getOne');
$router->addRoute('POST', '/tipospontosturisticos', 'TipoPontoTuristicoController@store');
$router->addRoute('PUT', '/tipospontosturisticos/{id}', 'TipoPontoTuristicoController@update');
$router->addRoute('DELETE', '/tipospontosturisticos/{id}', 'TipoPontoTuristicoController@delete');

//CRUD Interesses Viajantes Routes
$router->addRoute('POST', '/viajanteInteresses', 'InteresseViajanteController@store');

//CRUD Ponto Turistico Routes
$router->addRoute('POST', '/pontosturisticos', 'PontoTuristicoController@store');
$router->addRoute('GET', '/pontosturisticos', 'PontoTuristicoController@index');
$router->addRoute('GET', '/pontosturisticos/{id}', 'PontoTuristicoController@show');
$router->addRoute('DELETE', '/pontosturisticos/{id}', 'PontoTuristicoController@delete');

//CRUD ROTEIRO TURISTICOS Routes
$router->addRoute('GET', '/roteirosturisticos', 'RoteiroTuristicoController@index');
$router->addRoute('GET', '/roteirosturisticos/{id}', 'RoteiroTuristicoController@getOne');
$router->addRoute('POST', '/roteirosturisticos', 'RoteiroTuristicoController@store');
$router->addRoute('DELETE', '/roteirosturisticos/{id}', 'RoteiroTuristicoController@delete');
$router->addRoute('PUT', '/roteirosturisticos/{id}', 'RoteiroTuristicoController@update');

//CRUD Regiao Routes
$router->addRoute('POST', '/regiao', 'RegiaoController@store');

//Rotas de Pesquisa
$router->addRoute('GET', '/pesquisa', 'PesquisaController@pesquisa');
?>