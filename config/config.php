<?php

return [
    'data_source' => 'elastic',
    //'data_source' => 'mysql',
    'cache_driver' => 'file', 
    //'cache_driver' => 'redis',
    'redis' => [
        'host' => '127.0.0.1',
        'port' => 6379,
    ],
    'cacheTime'=> '20',   // seconds
    'cacheFile'=> '',
];