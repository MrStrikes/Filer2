<?php

$config = [
    'homepage_route' => 'home',
    'db' => [
        'name'     => 'Filer',
        'user'     => 'Filer',
        'password' => 'uMEUyBZDmXGJGTl9',
        'host'     => '127.0.0.1',
        'port'     => NULL
    ],
    'routes' => [
        'home'    => 'Main:home',
        'register' => 'Main:register',
        'login' => 'Main:login',
        'logout' => 'Main:logout'
    ]
];
