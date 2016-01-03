<?php

$scriptInvokedFromCli =
    isset($_SERVER['argv'][0]) && $_SERVER['argv'][0] === 'server.php';

if($scriptInvokedFromCli) {
    $port = getenv('PORT');
    if (empty($port)) {
        $port = "3000";
    }

    echo 'starting server on port '. $port . PHP_EOL;
    exec('php -S localhost:'. $port . ' -t public server.php');
} else {
    return routeRequest();
}


function routeRequest()
{   
    $uri = $_SERVER['REQUEST_URI'];
    if ($uri == '/') {
        $filestring = file_get_contents('./public/index.php');
        print $filestring;
    } 
    else {
        return false;
    }
} 
