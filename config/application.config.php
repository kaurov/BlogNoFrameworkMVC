<?php

return [
    // to start you need manually create the user in your MySQL:
    // CREATE USER 'blog'@'localhost' IDENTIFIED BY 'testpasBlogsword';

    // database connection parameters
    'connection' => [
        'database_type' => 'mysqli',
        'params' => [
            'host' => 'localhost',
            'port' => '3306',
            'user' => 'blog',
            'password' => 'testpasBlogsword',
            'dbname' => 'noframeworkblog',
        ]
    ]
];
