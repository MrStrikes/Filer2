<?php

$config = [
    'homepage_route' => 'home',
    'db' => [
        'name'     => 'YOUR_DATABASE_HERE',
        'user'     => 'YOUR_USERNAME_HERE',
        'password' => 'YOUR_PASSWORD_HERE',
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
        'edit' => 'Upload:edit',
        'folder' => 'Upload:folder'
    ]
];
