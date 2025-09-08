<?php

return [
    'web' => [
        '/' => 'HomeController@index',
    ],
    'api' => [
        'v1' => [
            'shorten' => 'ShortenController@shorten',
        ],
    ],
];
