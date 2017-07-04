<?php
/**
 * worker config file
 * @package worker
 * @version 0.0.1
 * @upgrade true
 */

return [
    '__name' => 'worker',
    '__version' => '0.0.1',
    '__git' => 'https://github.com/getphun/worker',
    '__files' => [
        'modules/worker'    => [ 'install', 'remove', 'update' ],
        'etc/worker/bin'    => [ 'install', 'remove', 'update' ],
        'etc/worker/jobs'   => [ 'install', 'remove' ],
        'etc/worker/result' => [ 'install', 'remove' ],
    ],
    '__dependencies' => [],
    '_services' => [
        'worker' => 'Worker\\Service\\Worker'
    ],
    '_autoload' => [
        'classes' => [
            'Worker\\Service\\Worker' => 'modules/worker/service/Worker.php'
        ],
        'files' => []
    ]
];