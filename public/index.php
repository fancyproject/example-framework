<?php

require_once(__DIR__.'/../vendor/autoload.php');

$kernel = new \Framework\Core\Kernel(true);
$response = $kernel->run();
$response->send();