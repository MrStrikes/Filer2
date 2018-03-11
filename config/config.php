<?php

$config = [
    'homepage_route' => 'home',
    'db' => [
        'name'     => 'filer2',
        'user'     => 'root',
        'password' => 'root',
        'host'     => '127.0.0.1',
        'port'     => 3306
    ],
    'routes' => [
        'home'    => 'Main:home',
        'register' => 'Main:register',
        'login' => 'Main:login',
        'logout' => 'Main:logout',
        'upload' => 'Upload:upload',
        'rename' => 'Upload:rename',
        'edit' => 'Upload:edit'
    ]
];
