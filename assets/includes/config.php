<?php

    $config = array(
        'title' => 'Магазин картин',
        'logo' => 'ArtShop',
        'SITE_KEY' => '6LdqXl4kAAAAAJPfuIGQ_wvOvqZt6Wf3GQm3fkq6',
        'SECRET_KEY' => '6LdqXl4kAAAAAJ_TZ5zJJQva5YO5K9aY_awHNMPO',
        'uploads' => '/media/',
        'db' => array(
            'server' => 'localhost',
            'username' => 'root',
            'password' => '',
            'name' => 'artshop'
        )
    );

    require_once "db.php";