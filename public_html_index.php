<?php

use Illuminate\Contracts\Http\Kernel;
use Illuminate\Http\Request;

define('LARAVEL_START', microtime(true));

if (file_exists($maintenance = __DIR__.'/../drehco/storage/framework/maintenance.php')) {
    require $maintenance;
}

require __DIR__.'/../drehco/vendor/autoload.php';

$app = require_once __DIR__.'/../drehco/bootstrap/app.php';

$app->bind('path.public', function() { return __DIR__; });

$kernel = $app->make(Kernel::class);

$response = $kernel->handle(
    $request = Request::capture()
)->send();

$kernel->terminate($request, $response);
