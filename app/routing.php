<?php

/**
 * @todo GET/POST
 */
return [
    '/foo/{age}' => [
        '_controller' => '\App\Controller\IndexController',
        '_action' => 'index',
        '_methods' => ['POST', 'GET'],
        '_route_name' => 'foo'
    ]
];
