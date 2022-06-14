<?php
require  (__DIR__."/vendor/autoload.php");

use Ratchet\Server\IoServer;
use Ratchet\Http\HttpServer;
use Ratchet\WebSocket\WsServer;
use ChatApp\Chat;
try {
$server = IoServer ::factory(
    new HttpServer(
        new WsServer(
            new Chat()
            )
        ),
    2222
);

$server->run();
}
catch(Exception $e)
{
    echo 'Message : '.$e->getMessage();
}

?>