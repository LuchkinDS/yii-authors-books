<?php
    return [
        'enablePrettyUrl' => true,
        'showScriptName' => false,
        'rules' => [
            // main author
            ['pattern' => '/', 'route' => 'site/index'],
            // login author
            ['pattern' => 'login', 'route' => 'site/login'],
            // books
            ['pattern' => 'books', 'route' => 'books/book/index'],
            ['pattern' => 'books/create', 'route' => 'books/book/create'],
            ['pattern' => 'books/<id:\d+>/update', 'route' => 'books/book/update'],
            ['pattern' => 'books/<id:\d+>/view', 'route' => 'books/book/view'],
            ['pattern' => 'books/<id:\d+>/delete', 'route' => 'books/book/delete'],
            // authors
            ['pattern' => 'authors', 'route' => 'authors/author/index'],
            ['pattern' => 'authors/create', 'route' => 'authors/author/create'],
            ['pattern' => 'authors/<id:\d+>/update', 'route' => 'authors/author/update'],
            ['pattern' => 'authors/<id:\d+>/view', 'route' => 'authors/author/view'],
            ['pattern' => 'authors/<id:\d+>/delete', 'route' => 'authors/author/delete'],
        ],
    ];
