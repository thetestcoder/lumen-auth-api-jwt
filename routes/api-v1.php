<?php


/** @var \Laravel\Lumen\Routing\Router $router */


$router->post('register', 'AuthController@register');
$router->post('login', 'AuthController@login');
$router->post('logout', 'AuthController@logout');
$router->post('refresh', 'AuthController@refresh');
$router->post('me', 'AuthController@me');
